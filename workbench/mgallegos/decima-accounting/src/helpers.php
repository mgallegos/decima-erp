<?php
/**
 * @file
 * Custom system helpers
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

  if ( ! function_exists('account_balance_update'))
  {
     /**
      * Account Balance Update
      *
      * @param  string  $value
      *
      * @return array
      */

      function account_balance_update($rows, $prefix, $includeAccountsWithCeroBalance = false, $outcomeOfTheExercise = 0)
      {
        $plBs = array('acct_bs_', 'acct_pl_');
        $tbGl = array('acct_tb_', 'acct_gl_');

        $totalIncome = $totalExpenses = 0;

        foreach ($rows as $key => &$row)
      	{
          if(empty($row[$prefix . 'parent_account_id']))
          {
            $retunValues = account_balance_update_aux($row[$prefix . 'account_id'], $rows, $prefix);

            $row[$prefix . 'debit']+=$retunValues['debit'];
            $row[$prefix . 'credit']+=$retunValues['credit'];
            $row['processed'] = 1;

            // if($prefix == 'acct_gl_')
            if(in_array($prefix, $tbGl))
            {
              $row[$prefix . 'total_debit']+=$retunValues['total_debit'];
              $row[$prefix . 'total_credit']+=$retunValues['total_credit'];
            }
          }
        }

        $newRows = array();
        $counter = $groupDebitTotal = $groupCreditTotal = $groupOpeningBalanceTotal = $groupBalanceTotal = 0;
        $totalText = '';

        foreach ($rows as $key => $row)
      	{
          $counter++;

          if($counter == 1)
          {
            if(in_array($prefix, $plBs))
            {
              $groupColumn = $row[$prefix . 'pl_bs_category'];
            }
          }

          // if($prefix == 'acct_gl_')
          if(in_array($prefix, $tbGl))
          {
            if($row[$prefix . 'balance_type'] == 'D')
            {
              $row[$prefix . 'opening_balance'] = $row[$prefix . 'total_debit'] - $row[$prefix . 'total_credit'];
              $row[$prefix . 'closing_balance'] = ($row[$prefix . 'total_debit'] + $row[$prefix . 'debit']) - ($row[$prefix . 'total_credit'] + $row[$prefix . 'credit']);
            }
            else
            {
              $row[$prefix . 'opening_balance'] = $row[$prefix . 'total_credit'] - $row[$prefix . 'total_debit'];
              $row[$prefix . 'closing_balance'] = ($row[$prefix . 'total_credit'] + $row[$prefix . 'credit']) - ($row[$prefix . 'total_debit'] + $row[$prefix . 'debit']);
            }
          }
          else
          {
            if($row[$prefix . 'balance_type'] == 'D')
            {
              $row[$prefix . 'balance'] = $row[$prefix . 'debit'] - $row[$prefix . 'credit'];
            }
            else
            {
              $row[$prefix . 'balance'] = $row[$prefix . 'credit'] - $row[$prefix . 'debit'];
            }
          }

          unset($row['processed']);

          if(in_array($prefix, $plBs) && $row[$prefix . 'pl_bs_category'] != $groupColumn)
          {
            array_push($newRows, array($prefix . 'debit' => $groupDebitTotal, $prefix . 'credit' => $groupCreditTotal, $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => 'Total (' . $totalText . ')', $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'pl_bs_category' => $groupColumn, $prefix . 'balance' => $groupBalanceTotal));
            $groupDebitTotal = $groupCreditTotal = $groupBalanceTotal = 0;
            $groupColumn = $row[$prefix . 'pl_bs_category'];
            $totalText = '';
          }

          if(empty($row[$prefix . 'parent_account_id']))
          {
            if($totalText == '')
            {
              $totalText .= $row[$prefix . 'account_name'];
            }
            else
            {
              $totalText = $totalText . ' + ' . $row[$prefix . 'account_name'];
            }

            // if($prefix != 'acct_gl_')
            if(in_array($prefix, $plBs))
            {
              $groupDebitTotal += $row[$prefix . 'debit'];
              $groupCreditTotal += $row[$prefix . 'credit'];
              $groupBalanceTotal += $row[$prefix . 'balance'];
            }

            if($prefix == 'acct_tb_')
            {
              $groupDebitTotal += $row[$prefix . 'debit'];
              $groupCreditTotal += $row[$prefix . 'credit'];
              // $groupOpeningBalanceTotal += $row[$prefix . 'opening_balance'];
              // $groupBalanceTotal += $row[$prefix . 'closing_balance'];
            }

            if($prefix == 'acct_pl_' && $row[$prefix . 'pl_bs_category'] == Lang::get('decima-accounting::profit-and-loss.income'))
            {
              $totalIncome += $row[$prefix . 'balance'];
            }
            else if($prefix == 'acct_pl_' && $row[$prefix . 'pl_bs_category'] == Lang::get('decima-accounting::profit-and-loss.expenses'))
            {
              $totalExpenses += $row[$prefix . 'balance'];
            }
          }

          // if($prefix == 'acct_gl_')
          if(in_array($prefix, $tbGl))
          {
            if($row[$prefix . 'total_debit'] == 0 && $row[$prefix . 'total_credit'] == 0 && $row[$prefix . 'debit'] == 0 && $row[$prefix . 'credit'] == 0)
            {
              if($includeAccountsWithCeroBalance)
              {
                array_push($newRows, $row);
              }
            }
            else
            {
              array_push($newRows, $row);
            }
          }
          // else if($prefix == 'acct_tb_')
          // {
          //   if($row[$prefix . 'debit'] == 0 && $row[$prefix . 'credit'] == 0)
          //   {
          //     if($includeAccountsWithCeroBalance)
          //     {
          //       array_push($newRows, $row);
          //     }
          //   }
          //   else
          //   {
          //     array_push($newRows, $row);
          //   }
          // }
          else
          {
            if($row[$prefix . 'balance'] == 0)
            {
              if($includeAccountsWithCeroBalance)
              {
                array_push($newRows, $row);
              }
            }
            else
            {
              array_push($newRows, $row);
            }
          }
        }

        if(in_array($prefix, $plBs))
        {
          if($prefix == 'acct_bs_')
          {
              $accountName = Lang::get('decima-accounting::profit-and-loss.outcomeOfTheExercise') . ' (' . Lang::get('decima-accounting::profit-and-loss.income') . ' - ' . Lang::get('decima-accounting::profit-and-loss.expenses') . ')';

              array_push($newRows, array($prefix . 'debit' => '0', $prefix . 'credit' => '0', $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => $accountName, $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'pl_bs_category' => $groupColumn, $prefix . 'balance' => $outcomeOfTheExercise));
              array_push($newRows, array($prefix . 'debit' => $groupDebitTotal, $prefix . 'credit' => $groupCreditTotal, $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => 'Total (' . $totalText . ' + ' . Lang::get('decima-accounting::profit-and-loss.outcomeOfTheExercise') . ')', $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'pl_bs_category' => $groupColumn, $prefix . 'balance' => $groupBalanceTotal + $outcomeOfTheExercise));
          }
          else
          {
            array_push($newRows, array($prefix . 'debit' => $groupDebitTotal, $prefix . 'credit' => $groupCreditTotal, $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => 'Total (' . $totalText . ')', $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'pl_bs_category' => $groupColumn, $prefix . 'balance' => $groupBalanceTotal + $outcomeOfTheExercise));
          }
        }

        if($prefix == 'acct_pl_')
        {
          $plBsCategory = Lang::get('decima-accounting::profit-and-loss.income') . ' - ' . Lang::get('decima-accounting::profit-and-loss.expenses');

          array_push($newRows, array($prefix . 'debit' => '0', $prefix . 'credit' => '0', $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => Lang::get('decima-accounting::profit-and-loss.outcomeOfTheExercise'), $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'pl_bs_category' => $plBsCategory, $prefix . 'balance' => $totalIncome - $totalExpenses));
        }

        if($prefix == 'acct_tb_')
        {
          // array_push($newRows, array($prefix . 'debit' => $groupDebitTotal, $prefix . 'credit' => $groupCreditTotal, $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => 'Total', $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'balance' => $groupDebitTotal - $groupCreditTotal));
          array_push($newRows, array($prefix . 'opening_balance' => '0', $prefix . 'debit' => $groupDebitTotal, $prefix . 'credit' => $groupCreditTotal, $prefix . 'account_id' => '', $prefix . 'parent_account_id' => '-1', $prefix . 'account_key' => '', $prefix . 'account_name' => 'Total', $prefix . 'is_group' => '1', $prefix . 'balance_type' => '', $prefix . 'closing_balance' => '0'));
        }

        return $newRows;
    }
   }

   if ( ! function_exists('account_balance_update_aux'))
   {
      /**
       * Account Balance Update Auxiliar
       *
       * @param  string  $value
       *
       * @return array
       */
      // function account_balance_update_aux($accountId, &$collection, $prefix)
      function account_balance_update_aux($accountId, &$rows, $prefix)
      {
        $tbGl = array('acct_tb_', 'acct_gl_');
        $values = array('debit' => 0, 'credit' => 0, 'total_debit' => 0, 'total_credit' => 0);

        foreach ($rows as $key => &$row)
        {
          if(empty($row[$prefix .'is_group']) && !isset($row['processed']))
          {
            $row['processed'] = 1;
          }

          if($row[$prefix . 'parent_account_id'] == $accountId)
          {
            if(isset($row['processed']))
            {
              $values['debit']+=$row[$prefix . 'debit'];
              $values['credit']+=$row[$prefix . 'credit'];

              // if($prefix == 'acct_gl_')
              if(in_array($prefix, $tbGl))
              {
                $values['total_debit']+=$row[$prefix . 'total_debit'];
                $values['total_credit']+=$row[$prefix . 'total_credit'];
              }
            }
            else
            {
              $retunValues = account_balance_update_aux($row[$prefix . 'account_id'], $rows, $prefix);
              $values['debit']+=$retunValues['debit'];
              $values['credit']+=$retunValues['credit'];
              $row[$prefix . 'debit']+=$retunValues['debit'];
              $row[$prefix . 'credit']+=$retunValues['credit'];
              $row['processed'] = 1;

              // if($prefix == 'acct_gl_')
              if(in_array($prefix, $tbGl))
              {
                $values['total_debit']+=$retunValues['total_debit'];
                $values['total_credit']+=$retunValues['total_credit'];
                $row[$prefix . 'total_debit']+=$retunValues['total_debit'];
                $row[$prefix . 'total_credit']+=$retunValues['total_credit'];
              }
            }
          }
        }

        return $values;
      }
    }

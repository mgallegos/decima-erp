<?php
/**
 * @file
 * Application listeners.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Kwaai\Helpers;

class AppProcessor
{
    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $trace = debug_backtrace();

        // skip first since it's always the current method
        array_shift($trace);
        // the call_user_func call is also skipped
        array_shift($trace);

        $i = 0;
        while (isset($trace[$i]['class']) && false !== strpos($trace[$i]['class'], 'Monolog\\')) {
            $i++;
        }

        // we should have the call source now
        $record['extra'] = array_merge(
            $record['extra'],
            array(
                //'file'      => isset($trace[$i-1]['file']) ? $trace[$i-1]['file'] : null,
                'user'    	=> 'admin@Kwaai.sv',
                'company'	=> 'Kwaai.inc',
                'catalog'	=> 'Cátalogo 2013',
            )
        );

        return $record;
    }
}

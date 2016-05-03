<?php
/**
 * @file
 * SEC_Currency Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\System\Currency;

class CurrencyTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SYS_Currency')->delete();

		Currency::create(array('iso_code' => 'AED', 'symbol' => 'د.إ', 'name' => 'UAE Dirham', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 1
		Currency::create(array('iso_code' => 'AFA', 'symbol' => 'Af', 'name' => 'Afghani', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 2
		Currency::create(array('iso_code' => 'ALL', 'symbol' => 'L', 'name' => 'Lek', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 3
		Currency::create(array('iso_code' => 'AMD', 'symbol' => 'դր.', 'name' => 'Armenian Dram', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 4
		Currency::create(array('iso_code' => 'ANG', 'symbol' => 'NAf.', 'name' => 'Netherlands Antillian Guilder', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 5
		Currency::create(array('iso_code' => 'AOA', 'symbol' => 'Kz', 'name' => 'Kwanza', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 6
		Currency::create(array('iso_code' => 'ARS', 'symbol' => '$', 'name' => 'Argentine Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 7
		Currency::create(array('iso_code' => 'ATS', 'symbol' => 'Sch', 'name' => 'Austrian Schilling', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 8
		Currency::create(array('iso_code' => 'AUD', 'symbol' => '$', 'name' => 'Australian Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 9
		Currency::create(array('iso_code' => 'AWG', 'symbol' => 'ƒ', 'name' => 'Aruban Guilder', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 10
		Currency::create(array('iso_code' => 'AZM', 'symbol' => 'm', 'name' => 'Azerbaijanian Manat', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 11
		Currency::create(array('iso_code' => 'BAM', 'symbol' => 'KM', 'name' => 'Convertible Marks', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 12
		Currency::create(array('iso_code' => 'BBD', 'symbol' => 'Bds$', 'name' => 'Barbados Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 13
		Currency::create(array('iso_code' => 'BDT', 'symbol' => '৳', 'name' => 'Taka', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 14
		Currency::create(array('iso_code' => 'BEF', 'symbol' => 'BFr', 'name' => 'Belgian Franc', 'standard_precision' => 0, 'costing_precision' => 0, 'price_precision' => 0, 'currency_symbol_at_the_right' => false));//id: 15
		Currency::create(array('iso_code' => 'BGL', 'symbol' => 'Lv', 'name' => 'Lev', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 16
		Currency::create(array('iso_code' => 'BGN', 'symbol' => 'лв', 'name' => 'Bulgarian Lev', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 17
		Currency::create(array('iso_code' => 'BHD', 'symbol' => 'ب.د', 'name' => 'Bahraini Dinar', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 18
		Currency::create(array('iso_code' => 'BIF', 'symbol' => 'FBu', 'name' => 'Burundi Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 19
		Currency::create(array('iso_code' => 'BMD', 'symbol' => 'Bd$', 'name' => 'Bermudian Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 20
		Currency::create(array('iso_code' => 'BND', 'symbol' => 'B$', 'name' => 'Brunei Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 21
		Currency::create(array('iso_code' => 'BOB', 'symbol' => 'Bs.', 'name' => 'Boliviano', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 22
		Currency::create(array('iso_code' => 'BRL', 'symbol' => 'R$', 'name' => 'Brazilian Real', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 23
		Currency::create(array('iso_code' => 'BSD', 'symbol' => 'B$', 'name' => 'Bahamian Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 24
		Currency::create(array('iso_code' => 'BSF', 'symbol' => 'Bs F', 'name' => 'Venezuelan BolÃ­var Fuerte', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 25
		Currency::create(array('iso_code' => 'BWP', 'symbol' => 'P', 'name' => 'Pula', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 26
		Currency::create(array('iso_code' => 'BYR', 'symbol' => 'BR', 'name' => 'Belarussian Ruble', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 27
		Currency::create(array('iso_code' => 'BZD', 'symbol' => 'BZ$', 'name' => 'Belize Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 28
		Currency::create(array('iso_code' => 'CAD', 'symbol' => 'C$', 'name' => 'Canadian Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 29
		Currency::create(array('iso_code' => 'CDF', 'symbol' => 'Fr', 'name' => 'Franc Congolais', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 30
		Currency::create(array('iso_code' => 'CHF', 'symbol' => 'SwF', 'name' => 'Swiss Franc', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 31
		Currency::create(array('iso_code' => 'CLP', 'symbol' => 'Ch$', 'name' => 'Chilean Peso', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 32
		Currency::create(array('iso_code' => 'CNY', 'symbol' => '¥', 'name' => 'Yuan Renminbi', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 33
		Currency::create(array('iso_code' => 'COP', 'symbol' => 'Col$', 'name' => 'Colombian Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 34
		Currency::create(array('iso_code' => 'CRC', 'symbol' => '₡', 'name' => 'Costa Rican Colon', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 35
		Currency::create(array('iso_code' => 'CUP', 'symbol' => 'Cu$', 'name' => 'Cuban Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 36
		Currency::create(array('iso_code' => 'CVE', 'symbol' => 'C.V.Esc.', 'name' => 'Cape Verde Escudo', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 37
		Currency::create(array('iso_code' => 'CYP', 'symbol' => '£C', 'name' => 'Cyprus Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 38
		Currency::create(array('iso_code' => 'CZK', 'symbol' => 'Kč', 'name' => 'Czech Koruna', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 39
		Currency::create(array('iso_code' => 'DEM', 'symbol' => 'DM', 'name' => 'Deutsche Mark', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 40
		Currency::create(array('iso_code' => 'DJF', 'symbol' => 'DF', 'name' => 'Djibouti Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 41
		Currency::create(array('iso_code' => 'DKK', 'symbol' => 'Dkr', 'name' => 'Danish Krone', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 42
		Currency::create(array('iso_code' => 'DOP', 'symbol' => 'RD$', 'name' => 'Dominican Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 43
		Currency::create(array('iso_code' => 'DZD', 'symbol' => 'د.ج', 'name' => 'Algerian Dinar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 44
		Currency::create(array('iso_code' => 'EEK', 'symbol' => 'KR', 'name' => 'Kroon', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 45
		Currency::create(array('iso_code' => 'EGP', 'symbol' => '£E', 'name' => 'Egyptian Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 46
		Currency::create(array('iso_code' => 'ERN', 'symbol' => 'Nfk', 'name' => 'Nakfa', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 47
		Currency::create(array('iso_code' => 'ESP', 'symbol' => 'Pts', 'name' => 'Spanish Peseta', 'standard_precision' => 0, 'costing_precision' => 0, 'price_precision' => 0, 'currency_symbol_at_the_right' => false));//id: 48
		Currency::create(array('iso_code' => 'ETB', 'symbol' => 'Br', 'name' => 'Ethiopian Birr', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 49
		Currency::create(array('iso_code' => 'EUR', 'symbol' => '€', 'name' => 'Euro', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => true));//id: 50
		Currency::create(array('iso_code' => 'FIM', 'symbol' => 'FM', 'name' => 'Finish Mark', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 51
		Currency::create(array('iso_code' => 'FJD', 'symbol' => 'F$', 'name' => 'Fiji Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 52
		Currency::create(array('iso_code' => 'FKP', 'symbol' => '£F', 'name' => 'Falkland Islands Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 53
		Currency::create(array('iso_code' => 'FRF', 'symbol' => 'Fr', 'name' => 'French Franc', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 54
		Currency::create(array('iso_code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 55
		Currency::create(array('iso_code' => 'GEL', 'symbol' => 'ლ', 'name' => 'Lari', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 56
		Currency::create(array('iso_code' => 'GHC', 'symbol' => '¢', 'name' => 'Cedi', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 57
		Currency::create(array('iso_code' => 'GIP', 'symbol' => '£G', 'name' => 'Gibraltar Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 58
		Currency::create(array('iso_code' => 'GMD', 'symbol' => 'D', 'name' => 'Dalasi', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 59
		Currency::create(array('iso_code' => 'GNF', 'symbol' => 'Fr', 'name' => 'Guinea Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 60
		Currency::create(array('iso_code' => 'GTQ', 'symbol' => 'Q', 'name' => 'Quetzal', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 61
		Currency::create(array('iso_code' => 'GWP', 'symbol' => '$', 'name' => 'Guinea-Bissau Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 62
		Currency::create(array('iso_code' => 'GYD', 'symbol' => 'G$', 'name' => 'Guyana Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 63
		Currency::create(array('iso_code' => 'HKD', 'symbol' => 'HK$', 'name' => 'Hong Kong Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 64
		Currency::create(array('iso_code' => 'HNL', 'symbol' => 'L', 'name' => 'Lempira', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 65
		Currency::create(array('iso_code' => 'HRK', 'symbol' => 'kn', 'name' => 'Croatian Kuna', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 66
		Currency::create(array('iso_code' => 'HTG', 'symbol' => 'G', 'name' => 'Gourde', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 67
		Currency::create(array('iso_code' => 'HUF', 'symbol' => 'Ft', 'name' => 'Forint', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 68
		Currency::create(array('iso_code' => 'IDR', 'symbol' => 'Rp', 'name' => 'Rupiah', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 69
		Currency::create(array('iso_code' => 'IEP', 'symbol' => 'I£', 'name' => 'Irish Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 70
		Currency::create(array('iso_code' => 'ILS', 'symbol' => '₪', 'name' => 'New Israeli Sheqel', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 71
		Currency::create(array('iso_code' => 'INR', 'symbol' => 'Rs', 'name' => 'Indian Rupee', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 72
		Currency::create(array('iso_code' => 'IQD', 'symbol' => 'ع.د', 'name' => 'Iraqi Dinar', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 73
		Currency::create(array('iso_code' => 'IRR', 'symbol' => '﷼', 'name' => 'Iranian Rial', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 74
		Currency::create(array('iso_code' => 'ISK', 'symbol' => 'IKr', 'name' => 'Iceland Krona', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 75
		Currency::create(array('iso_code' => 'ITL', 'symbol' => 'L', 'name' => 'Italian Lira', 'standard_precision' => 0, 'costing_precision' => 0, 'price_precision' => 0, 'currency_symbol_at_the_right' => false));//id: 76
		Currency::create(array('iso_code' => 'JMD', 'symbol' => 'J$', 'name' => 'Jamaican Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 77
		Currency::create(array('iso_code' => 'JOD', 'symbol' => 'د.ا', 'name' => 'Jordanian Dinar', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 78
		Currency::create(array('iso_code' => 'JPY', 'symbol' => '¥', 'name' => 'Japanese Yen', 'standard_precision' => 0, 'costing_precision' => 0, 'price_precision' => 0, 'currency_symbol_at_the_right' => false));//id: 79
		Currency::create(array('iso_code' => 'KES', 'symbol' => 'K Sh', 'name' => 'Kenyan Shilling', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 80
		Currency::create(array('iso_code' => 'KGS', 'symbol' => 'som', 'name' => 'Som', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 81
		Currency::create(array('iso_code' => 'KHR', 'symbol' => 'CR', 'name' => 'Riel', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 82
		Currency::create(array('iso_code' => 'KMF', 'symbol' => 'CF', 'name' => 'Comoro Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 83
		Currency::create(array('iso_code' => 'KPW', 'symbol' => '₩', 'name' => 'North Korean Won', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 84
		Currency::create(array('iso_code' => 'KRW', 'symbol' => 'W', 'name' => 'Won', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 85
		Currency::create(array('iso_code' => 'KWD', 'symbol' => 'د.ك', 'name' => 'Kuwaiti Dinar', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 86
		Currency::create(array('iso_code' => 'KYD', 'symbol' => 'CI$', 'name' => 'Cayman Islands Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 87
		Currency::create(array('iso_code' => 'KZT', 'symbol' => '〒', 'name' => 'Tenge', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 88
		Currency::create(array('iso_code' => 'LAK', 'symbol' => '₭', 'name' => 'Kip', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 89
		Currency::create(array('iso_code' => 'LBP', 'symbol' => 'ل.ل', 'name' => 'Lebanese Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 90
		Currency::create(array('iso_code' => 'LKR', 'symbol' => 'SLRs', 'name' => 'Sri Lanka Rupee', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 91
		Currency::create(array('iso_code' => 'LRD', 'symbol' => '$', 'name' => 'Liberian Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 92
		Currency::create(array('iso_code' => 'LTL', 'symbol' => 'Lt', 'name' => 'Lithuanian Litas', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 93
		Currency::create(array('iso_code' => 'LVL', 'symbol' => 'ل.د', 'name' => 'Latvian Lats', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 94
		Currency::create(array('iso_code' => 'LYD', 'symbol' => 'LD', 'name' => 'Libyan Dinar', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 95
		Currency::create(array('iso_code' => 'MAD', 'symbol' => 'د.م.', 'name' => 'Moroccan Dirham', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 96
		Currency::create(array('iso_code' => 'MDL', 'symbol' => 'L', 'name' => 'Moldovan Leu', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 97
		Currency::create(array('iso_code' => 'MGF', 'symbol' => 'FMG', 'name' => 'Malagasy Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 98
		Currency::create(array('iso_code' => 'MKD', 'symbol' => 'ден', 'name' => 'Denar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 99
		Currency::create(array('iso_code' => 'MMK', 'symbol' => 'K', 'name' => 'Kyat', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 100
		Currency::create(array('iso_code' => 'MNT', 'symbol' => 'Tug', 'name' => 'Tugrik', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 101
		Currency::create(array('iso_code' => 'MOP', 'symbol' => 'P', 'name' => 'Pataca', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 102
		Currency::create(array('iso_code' => 'MRO', 'symbol' => 'UM', 'name' => 'Ouguiya', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 103
		Currency::create(array('iso_code' => 'MTL', 'symbol' => 'Lm', 'name' => 'Maltese Lira', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 104
		Currency::create(array('iso_code' => 'MUR', 'symbol' => 'Mau Rs', 'name' => 'Mauritius Rupee', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 105
		Currency::create(array('iso_code' => 'MVR', 'symbol' => 'Rf', 'name' => 'Rufiyaa', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 106
		Currency::create(array('iso_code' => 'MWK', 'symbol' => 'MK', 'name' => 'Kwacha', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 107
		Currency::create(array('iso_code' => 'MXN', 'symbol' => '$', 'name' => 'Mexican Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 108
		Currency::create(array('iso_code' => 'MYR', 'symbol' => 'RM', 'name' => 'Malaysian Ringgit', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 109
		Currency::create(array('iso_code' => 'MZN', 'symbol' => 'MTn', 'name' => 'Metical', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 110
		Currency::create(array('iso_code' => 'NGN', 'symbol' => '₦', 'name' => 'Naira', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 111
		Currency::create(array('iso_code' => 'NIO', 'symbol' => 'C$', 'name' => 'Cordoba Oro', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 112
		Currency::create(array('iso_code' => 'NLF', 'symbol' => 'Fl', 'name' => 'Dutch Guilder', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 113
		Currency::create(array('iso_code' => 'NOK', 'symbol' => 'NKr', 'name' => 'Norwegian Krone', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 114
		Currency::create(array('iso_code' => 'NPR', 'symbol' => 'NRs', 'name' => 'Nepalese Rupee', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 115
		Currency::create(array('iso_code' => 'NZD', 'symbol' => '$', 'name' => 'New Zealand Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 116
		Currency::create(array('iso_code' => 'OMR', 'symbol' => 'ر.ع.', 'name' => 'Rial Omani', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 117
		Currency::create(array('iso_code' => 'PAB', 'symbol' => 'B/.', 'name' => 'Balboa', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 118
		Currency::create(array('iso_code' => 'PEN', 'symbol' => 'S/.', 'name' => 'Nuevo Sol', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 119
		Currency::create(array('iso_code' => 'PGK', 'symbol' => 'K', 'name' => 'Kina', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 120
		Currency::create(array('iso_code' => 'PHP', 'symbol' => '₱', 'name' => 'Philippine Peso', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 121
		Currency::create(array('iso_code' => 'PKR', 'symbol' => 'Rs', 'name' => 'Pakistan Rupee', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 122
		Currency::create(array('iso_code' => 'PLN', 'symbol' => 'zł', 'name' => 'Zloty', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 123
		Currency::create(array('iso_code' => 'PTE', 'symbol' => 'Es', 'name' => 'Portugese Escudo', 'standard_precision' => 0, 'costing_precision' => 0, 'price_precision' => 0, 'currency_symbol_at_the_right' => false));//id: 124
		Currency::create(array('iso_code' => 'PYG', 'symbol' => '₲', 'name' => 'Guarani', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 125
		Currency::create(array('iso_code' => 'QAR', 'symbol' => 'ر.ق', 'name' => 'Qatari Rial', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 126
		Currency::create(array('iso_code' => 'ROL', 'symbol' => 'L', 'name' => 'Leu', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 127
		Currency::create(array('iso_code' => 'RON', 'symbol' => 'L', 'name' => 'Romanian Leu', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 128
		Currency::create(array('iso_code' => 'RSD', 'symbol' => 'дин', 'name' => 'Serbian Dinar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 129
		Currency::create(array('iso_code' => 'RUB', 'symbol' => 'руб.', 'name' => 'Russian Ruble', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 130
		Currency::create(array('iso_code' => 'RWF', 'symbol' => 'RF', 'name' => 'Rwanda Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 131
		Currency::create(array('iso_code' => 'SAR', 'symbol' => 'ر.س', 'name' => 'Saudi Riyal', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 132
		Currency::create(array('iso_code' => 'SBD', 'symbol' => 'SI$', 'name' => 'Solomon Islands Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 133
		Currency::create(array('iso_code' => 'SCR', 'symbol' => 'SR', 'name' => 'Seychelles Rupee', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 134
		Currency::create(array('iso_code' => 'SDG', 'symbol' => '£', 'name' => 'Sudanese Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 135
		Currency::create(array('iso_code' => 'SEK', 'symbol' => 'kr', 'name' => 'Swedish Krona', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 136
		Currency::create(array('iso_code' => 'SFR', 'symbol' => 'SFr', 'name' => 'Swiss Franc', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 137
		Currency::create(array('iso_code' => 'SGD', 'symbol' => 'S$', 'name' => 'Singapore Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 138
		Currency::create(array('iso_code' => 'SHP', 'symbol' => '£S', 'name' => 'Saint Helena Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 139
		Currency::create(array('iso_code' => 'SKK', 'symbol' => 'Sk', 'name' => 'Slovak Koruna', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 140
		Currency::create(array('iso_code' => 'SLL', 'symbol' => 'Le', 'name' => 'Leone', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 141
		Currency::create(array('iso_code' => 'SOS', 'symbol' => 'So. Sh.', 'name' => 'Somali Shilling', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 142
		Currency::create(array('iso_code' => 'SRD', 'symbol' => '$', 'name' => 'Suriname Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 143
		Currency::create(array('iso_code' => 'STD', 'symbol' => 'Db', 'name' => 'Dobra', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 144
		Currency::create(array('iso_code' => 'SVC', 'symbol' => '¢', 'name' => 'El Salvador Colon', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 145
		Currency::create(array('iso_code' => 'SYP', 'symbol' => '£S', 'name' => 'Syrian Pound', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 146
		Currency::create(array('iso_code' => 'SZL', 'symbol' => 'L', 'name' => 'Lilangeni', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 147
		Currency::create(array('iso_code' => 'THB', 'symbol' => '฿', 'name' => 'Baht', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 148
		Currency::create(array('iso_code' => 'TJS', 'symbol' => 'SM', 'name' => 'Somoni', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 149
		Currency::create(array('iso_code' => 'TMM', 'symbol' => 'm', 'name' => 'Manat', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 150
		Currency::create(array('iso_code' => 'TND', 'symbol' => 'د.ت', 'name' => 'Tunisian Dinar', 'standard_precision' => 3, 'costing_precision' => 5, 'price_precision' => 5, 'currency_symbol_at_the_right' => false));//id: 151
		Currency::create(array('iso_code' => 'TOP', 'symbol' => 'T$', 'name' => 'Pa’anga', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 152
		Currency::create(array('iso_code' => 'TPE', 'symbol' => '$', 'name' => 'Timor Escudo', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 153
		Currency::create(array('iso_code' => 'TRY', 'symbol' => 'YTL', 'name' => 'Turkish Lira', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 154
		Currency::create(array('iso_code' => 'TTD', 'symbol' => 'TT$', 'name' => 'Trinidad and Tobago Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 155
		Currency::create(array('iso_code' => 'TWD', 'symbol' => 'NT$', 'name' => 'New Taiwan Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 156
		Currency::create(array('iso_code' => 'TZS', 'symbol' => 'TSh', 'name' => 'Tanzanian Shilling', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 157
		Currency::create(array('iso_code' => 'UAH', 'symbol' => '₴', 'name' => 'Hryvnia', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 158
		Currency::create(array('iso_code' => 'UGX', 'symbol' => 'USh', 'name' => 'Uganda Shilling', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 159
		Currency::create(array('iso_code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 160
		Currency::create(array('iso_code' => 'UYU', 'symbol' => '$U', 'name' => 'Peso Uruguayo', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 161
		Currency::create(array('iso_code' => 'UZS', 'symbol' => 'som', 'name' => 'Uzbekistan Sum', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 162
		Currency::create(array('iso_code' => 'VEB', 'symbol' => 'Bs', 'name' => 'Bolivar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 163
		Currency::create(array('iso_code' => 'VND', 'symbol' => '₫', 'name' => 'Dong', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 164
		Currency::create(array('iso_code' => 'VUV', 'symbol' => 'VT', 'name' => 'Vatu', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 165
		Currency::create(array('iso_code' => 'WST', 'symbol' => 'WS$', 'name' => 'Tala', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 166
		Currency::create(array('iso_code' => 'XAF', 'symbol' => 'CFAF', 'name' => 'CFA Franc BEAC', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 167
		Currency::create(array('iso_code' => 'XCD', 'symbol' => 'EC$', 'name' => 'East Caribbean Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 168
		Currency::create(array('iso_code' => 'XOF', 'symbol' => 'CFAF', 'name' => 'CFA Franc BCEAO', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 169
		Currency::create(array('iso_code' => 'XPF', 'symbol' => 'CFPF', 'name' => 'CFP Franc', 'standard_precision' => 0, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 170
		Currency::create(array('iso_code' => 'YER', 'symbol' => '﷼', 'name' => 'Yemeni Rial', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 171
		Currency::create(array('iso_code' => 'YUM', 'symbol' => 'Din', 'name' => 'Yugoslavian Dinar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 172
		Currency::create(array('iso_code' => 'ZAR', 'symbol' => 'R', 'name' => 'Rand', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 173
		Currency::create(array('iso_code' => 'ZMK', 'symbol' => 'ZK', 'name' => 'Kwacha', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 174
		Currency::create(array('iso_code' => 'ZWD', 'symbol' => 'Z$', 'name' => 'Zimbabwe Dollar', 'standard_precision' => 2, 'costing_precision' => 2, 'price_precision' => 2, 'currency_symbol_at_the_right' => false));//id: 175
	}

}

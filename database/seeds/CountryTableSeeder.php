<?php
/**
 * @file
 * SEC_Country Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\System\Country;

class CountryTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SYS_Country')->delete();

		Country::create(array('iso_code' => 'AND', 'name' => "Andorra", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 1 currency: EUR
		Country::create(array('iso_code' => 'ARE', 'name' => "United Arab Emirates", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 1));//id: 2 currency: AED
		Country::create(array('iso_code' => 'AFG', 'name' => "Afghanistan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 2));//id: 3 currency: AFA
		Country::create(array('iso_code' => 'ATG', 'name' => "Antigua And Barbuda", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 4 currency: XCD
		Country::create(array('iso_code' => 'AIA', 'name' => "Anguilla", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 5 currency: XCD
		Country::create(array('iso_code' => 'ALB', 'name' => "Albania", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 3));//id: 6 currency: ALL
		Country::create(array('iso_code' => 'ARM', 'name' => "Armenia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 4));//id: 7 currency: AMD
		Country::create(array('iso_code' => 'ANT', 'name' => "Netherlands Antilles", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 5));//id: 8 currency: ANG
		Country::create(array('iso_code' => 'AGO', 'name' => "Angola", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 6));//id: 9 currency: AOA
		Country::create(array('iso_code' => 'ATA', 'name' => "Antarctica", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 10 currency:
		Country::create(array('iso_code' => 'ARG', 'name' => "Argentina", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 7));//id: 11 currency: ARS
		Country::create(array('iso_code' => 'ASM', 'name' => "American Samoa", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 12 currency: USD
		Country::create(array('iso_code' => 'AUT', 'name' => "Austria", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 13 currency: EUR
		Country::create(array('iso_code' => 'AUS', 'name' => "Australia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 14 currency: AUD
		Country::create(array('iso_code' => 'ABW', 'name' => "Aruba", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 10));//id: 15 currency: AWG
		Country::create(array('iso_code' => 'AZE', 'name' => "Azerbaijan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 11));//id: 16 currency: AZM
		Country::create(array('iso_code' => 'BIH', 'name' => "Bosnia And Herzegovina", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 12));//id: 17 currency: BAM
		Country::create(array('iso_code' => 'BRB', 'name' => "Barbados", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 13));//id: 18 currency: BBD
		Country::create(array('iso_code' => 'BGD', 'name' => "Bangladesh", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 14));//id: 19 currency: BDT
		Country::create(array('iso_code' => 'BEL', 'name' => "Belgium", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 20 currency: EUR
		Country::create(array('iso_code' => 'BFA', 'name' => "Burkina Faso", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 21 currency: XOF
		Country::create(array('iso_code' => 'BGR', 'name' => "Bulgaria", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 16));//id: 22 currency: BGL
		Country::create(array('iso_code' => 'BHR', 'name' => "Bahrain", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 18));//id: 23 currency: BHD
		Country::create(array('iso_code' => 'BDI', 'name' => "Burundi", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 19));//id: 24 currency: BIF
		Country::create(array('iso_code' => 'BEN', 'name' => "Benin", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 25 currency: XOF
		Country::create(array('iso_code' => 'BMU', 'name' => "Bermuda", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 20));//id: 26 currency: BMD
		Country::create(array('iso_code' => 'BRN', 'name' => "Brunei Darussalam", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 21));//id: 27 currency: BND
		Country::create(array('iso_code' => 'BOL', 'name' => "Bolivia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 22));//id: 28 currency: BOB
		Country::create(array('iso_code' => 'BRA', 'name' => "Brazil", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 23));//id: 29 currency: BRL
		Country::create(array('iso_code' => 'BHS', 'name' => "Bahamas", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 24));//id: 30 currency: BSD
		Country::create(array('iso_code' => 'BTN', 'name' => "Bhutan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 72));//id: 31 currency: INR
		Country::create(array('iso_code' => 'BVT', 'name' => "Bouvet Island", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 32 currency:
		Country::create(array('iso_code' => 'BWA', 'name' => "Botswana", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 26));//id: 33 currency: BWP
		Country::create(array('iso_code' => 'BLR', 'name' => "Belarus", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 27));//id: 34 currency: BYR
		Country::create(array('iso_code' => 'BLZ', 'name' => "Belize", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 28));//id: 35 currency: BZD
		Country::create(array('iso_code' => 'CAN', 'name' => "Canada", 'region_name' => 'Province', 'region_lang_key' => 'system/country.province', 'currency_id' => 29));//id: 36 currency: CAD
		Country::create(array('iso_code' => 'CCK', 'name' => "Cocos (Keeling) Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 37 currency: AUD
		Country::create(array('iso_code' => 'COD', 'name' => "Congo The Democratic Republic Of The", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 30));//id: 38 currency: CDF
		Country::create(array('iso_code' => 'CAF', 'name' => "Central African Republic", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 167));//id: 39 currency: XAF
		Country::create(array('iso_code' => 'COG', 'name' => "Congo", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 167));//id: 40 currency: XAF
		Country::create(array('iso_code' => 'CHE', 'name' => "Switzerland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 31));//id: 41 currency: CHF
		Country::create(array('iso_code' => 'CIV', 'name' => "Cote D'Ivoire", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 42 currency: XOF
		Country::create(array('iso_code' => 'COK', 'name' => "Cook Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 116));//id: 43 currency: NZD
		Country::create(array('iso_code' => 'CHL', 'name' => "Chile", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 32));//id: 44 currency: CLP
		Country::create(array('iso_code' => 'CMR', 'name' => "Cameroon", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 167));//id: 45 currency: XAF
		Country::create(array('iso_code' => 'CHN', 'name' => "China", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 33));//id: 46 currency: CNY
		Country::create(array('iso_code' => 'COL', 'name' => "Colombia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 34));//id: 47 currency: COP
		Country::create(array('iso_code' => 'CRI', 'name' => "Costa Rica", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 35));//id: 48 currency: CRC
		Country::create(array('iso_code' => 'CUB', 'name' => "Cuba", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 36));//id: 49 currency: CUP
		Country::create(array('iso_code' => 'CPV', 'name' => "Cape Verde", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 37));//id: 50 currency: CVE
		Country::create(array('iso_code' => 'CXR', 'name' => "Christmas Island", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 51 currency: AUD
		Country::create(array('iso_code' => 'CYP', 'name' => "Cyprus", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 38));//id: 52 currency: CYP
		Country::create(array('iso_code' => 'CZE', 'name' => "Czech Republic", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 39));//id: 53 currency: CZK
		Country::create(array('iso_code' => 'DEU', 'name' => "Germany", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 54 currency: EUR
		Country::create(array('iso_code' => 'DJI', 'name' => "Djibouti", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 41));//id: 55 currency: DJF
		Country::create(array('iso_code' => 'DNK', 'name' => "Denmark", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 42));//id: 56 currency: DKK
		Country::create(array('iso_code' => 'DMA', 'name' => "Dominica", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 57 currency: XCD
		Country::create(array('iso_code' => 'DOM', 'name' => "Dominican Republic", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 43));//id: 58 currency: DOP
		Country::create(array('iso_code' => 'DZA', 'name' => "Algeria", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 44));//id: 59 currency: DZD
		Country::create(array('iso_code' => 'ECU', 'name' => "Ecuador", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 60 currency: USD
		Country::create(array('iso_code' => 'EST', 'name' => "Estonia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 45));//id: 61 currency: EEK
		Country::create(array('iso_code' => 'EGY', 'name' => "Egypt", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 46));//id: 62 currency: EGP
		Country::create(array('iso_code' => 'ESH', 'name' => "Western Sahara", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 63 currency:
		Country::create(array('iso_code' => 'ERI', 'name' => "Eritrea", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 47));//id: 64 currency: ERN
		Country::create(array('iso_code' => 'ESP', 'name' => "Spain", 'region_name' => 'Provincia', 'region_lang_key' => 'system/country.provincia', 'currency_id' => 50));//id: 65 currency: EUR
		Country::create(array('iso_code' => 'ETH', 'name' => "Ethiopia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 49));//id: 66 currency: ETB
		Country::create(array('iso_code' => 'FIN', 'name' => "Finland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 67 currency: EUR
		Country::create(array('iso_code' => 'FJI', 'name' => "Fiji", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 52));//id: 68 currency: FJD
		Country::create(array('iso_code' => 'FLK', 'name' => "Falkland Islands (Malvinas)", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 53));//id: 69 currency: FKP
		Country::create(array('iso_code' => 'FSM', 'name' => "Micronesia Federated States Of", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 70 currency: USD
		Country::create(array('iso_code' => 'FRO', 'name' => "Faroe Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 42));//id: 71 currency: DKK
		Country::create(array('iso_code' => 'FRA', 'name' => "France", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 72 currency: EUR
		Country::create(array('iso_code' => 'GAB', 'name' => "Gabon", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 167));//id: 73 currency: XAF
		Country::create(array('iso_code' => 'GBR', 'name' => "United Kingdom", 'region_name' => 'County', 'region_lang_key' => 'system/country.county', 'currency_id' => 55));//id: 74 currency: GBP
		Country::create(array('iso_code' => 'GRD', 'name' => "Grenada", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 75 currency: XCD
		Country::create(array('iso_code' => 'GEO', 'name' => "Georgia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 56));//id: 76 currency: GEL
		Country::create(array('iso_code' => 'GUF', 'name' => "French Guiana", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 77 currency: EUR
		Country::create(array('iso_code' => 'GHA', 'name' => "Ghana", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 57));//id: 78 currency: GHC
		Country::create(array('iso_code' => 'GIB', 'name' => "Gibraltar", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 58));//id: 79 currency: GIP
		Country::create(array('iso_code' => 'GRL', 'name' => "Greenland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 42));//id: 80 currency: DKK
		Country::create(array('iso_code' => 'GMB', 'name' => "Gambia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 59));//id: 81 currency: GMD
		Country::create(array('iso_code' => 'GIN', 'name' => "Guinea", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 60));//id: 82 currency: GNF
		Country::create(array('iso_code' => 'GLP', 'name' => "Guadeloupe", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 83 currency: EUR
		Country::create(array('iso_code' => 'GNQ', 'name' => "Equatorial Guinea", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 167));//id: 84 currency: XAF
		Country::create(array('iso_code' => 'GRC', 'name' => "Greece", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 85 currency: EUR
		Country::create(array('iso_code' => 'SGS', 'name' => "South Georgia And The South Sandwich Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 86 currency:
		Country::create(array('iso_code' => 'GTM', 'name' => "Guatemala", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 61));//id: 87 currency: GTQ
		Country::create(array('iso_code' => 'GUM', 'name' => "Guam", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 88 currency: USD
		Country::create(array('iso_code' => 'GNB', 'name' => "Guinea-Bissau", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 62));//id: 89 currency: GWP
		Country::create(array('iso_code' => 'GUY', 'name' => "Guyana", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 63));//id: 90 currency: GYD
		Country::create(array('iso_code' => 'HKG', 'name' => "Hong Kong", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 64));//id: 91 currency: HKD
		Country::create(array('iso_code' => 'HMD', 'name' => "Heard Island And Mcdonald Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 92 currency:
		Country::create(array('iso_code' => 'HND', 'name' => "Honduras", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 65));//id: 93 currency: HNL
		Country::create(array('iso_code' => 'HRV', 'name' => "Croatia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 66));//id: 94 currency: HRK
		Country::create(array('iso_code' => 'HTI', 'name' => "Haiti", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 67));//id: 95 currency: HTG
		Country::create(array('iso_code' => 'HUN', 'name' => "Hungary", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 68));//id: 96 currency: HUF
		Country::create(array('iso_code' => 'IDN', 'name' => "Indonesia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 69));//id: 97 currency: IDR
		Country::create(array('iso_code' => 'IRL', 'name' => "Ireland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 98 currency: EUR
		Country::create(array('iso_code' => 'ISR', 'name' => "Israel", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 71));//id: 99 currency: ILS
		Country::create(array('iso_code' => 'IND', 'name' => "India", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 72));//id: 100 currency: INR
		Country::create(array('iso_code' => 'IOT', 'name' => "British Indian Ocean Territory", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 101 currency:
		Country::create(array('iso_code' => 'IRQ', 'name' => "Iraq", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 73));//id: 102 currency: IQD
		Country::create(array('iso_code' => 'IRN', 'name' => "Iran Islamic Republic Of", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 74));//id: 103 currency: IRR
		Country::create(array('iso_code' => 'ISL', 'name' => "Iceland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 75));//id: 104 currency: ISK
		Country::create(array('iso_code' => 'ITA', 'name' => "Italy", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 105 currency: EUR
		Country::create(array('iso_code' => 'JAM', 'name' => "Jamaica", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 77));//id: 106 currency: JMD
		Country::create(array('iso_code' => 'JOR', 'name' => "Jordan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 78));//id: 107 currency: JOD
		Country::create(array('iso_code' => 'JPN', 'name' => "Japan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 79));//id: 108 currency: JPY
		Country::create(array('iso_code' => 'KEN', 'name' => "Kenya", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 80));//id: 109 currency: KES
		Country::create(array('iso_code' => 'KGZ', 'name' => "Kyrgyzstan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 81));//id: 110 currency: KGS
		Country::create(array('iso_code' => 'KHM', 'name' => "Cambodia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 82));//id: 111 currency: KHR
		Country::create(array('iso_code' => 'KIR', 'name' => "Kiribati", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 112 currency: AUD
		Country::create(array('iso_code' => 'COM', 'name' => "Comoros", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 83));//id: 113 currency: KMF
		Country::create(array('iso_code' => 'KNA', 'name' => "Saint Kitts And Nevis", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 114 currency: XCD
		Country::create(array('iso_code' => 'PRK', 'name' => "Korea Democratic People's Republic Of", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 84));//id: 115 currency: KPW
		Country::create(array('iso_code' => 'KOR', 'name' => "Korea Republic Of", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 85));//id: 116 currency: KRW
		Country::create(array('iso_code' => 'KWT', 'name' => "Kuwait", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 86));//id: 117 currency: KWD
		Country::create(array('iso_code' => 'CYM', 'name' => "Cayman Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 87));//id: 118 currency: KYD
		Country::create(array('iso_code' => 'KAZ', 'name' => "Kazakhstan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 88));//id: 119 currency: KZT
		Country::create(array('iso_code' => 'LAO', 'name' => "Lao People's Democratic Republic", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 89));//id: 120 currency: LAK
		Country::create(array('iso_code' => 'LBN', 'name' => "Lebanon", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 90));//id: 121 currency: LBP
		Country::create(array('iso_code' => 'LCA', 'name' => "Saint Lucia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 122 currency: XCD
		Country::create(array('iso_code' => 'LIE', 'name' => "Liechtenstein", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 31));//id: 123 currency: CHF
		Country::create(array('iso_code' => 'LKA', 'name' => "Sri Lanka", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 91));//id: 124 currency: LKR
		Country::create(array('iso_code' => 'LBR', 'name' => "Liberia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 92));//id: 125 currency: LRD
		Country::create(array('iso_code' => 'LSO', 'name' => "Lesotho", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 173));//id: 126 currency: ZAR
		Country::create(array('iso_code' => 'LTU', 'name' => "Lithuania", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 93));//id: 127 currency: LTL
		Country::create(array('iso_code' => 'LUX', 'name' => "Luxembourg", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 128 currency: EUR
		Country::create(array('iso_code' => 'LVA', 'name' => "Latvia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 94));//id: 129 currency: LVL
		Country::create(array('iso_code' => 'LBY', 'name' => "Libyan Arab Jamahiriya", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 95));//id: 130 currency: LYD
		Country::create(array('iso_code' => 'MAR', 'name' => "Morocco", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 96));//id: 131 currency: MAD
		Country::create(array('iso_code' => 'MCO', 'name' => "Monaco", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 132 currency: EUR
		Country::create(array('iso_code' => 'MDA', 'name' => "Moldova", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 97));//id: 133 currency: MDL
		Country::create(array('iso_code' => 'MNE', 'name' => "Montenegro", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 134 currency: EUR
		Country::create(array('iso_code' => 'MDG', 'name' => "Madagascar", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 98));//id: 135 currency: MGF
		Country::create(array('iso_code' => 'MHL', 'name' => "Marshall Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 136 currency: USD
		Country::create(array('iso_code' => 'MKD', 'name' => "Macedonia, The Former Yugoslav Republic Of", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 99));//id: 137 currency: MKD
		Country::create(array('iso_code' => 'MLI', 'name' => "Mali", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 138 currency: XOF
		Country::create(array('iso_code' => 'MMR', 'name' => "Myanmar", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 100));//id: 139 currency: MMK
		Country::create(array('iso_code' => 'MNG', 'name' => "Mongolia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 101));//id: 140 currency: MNT
		Country::create(array('iso_code' => 'MAC', 'name' => "Macao", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 102));//id: 141 currency: MOP
		Country::create(array('iso_code' => 'MNP', 'name' => "Northern Mariana Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 142 currency: USD
		Country::create(array('iso_code' => 'MTQ', 'name' => "Martinique", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 143 currency: EUR
		Country::create(array('iso_code' => 'MRT', 'name' => "Mauritania", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 103));//id: 144 currency: MRO
		Country::create(array('iso_code' => 'MSR', 'name' => "Montserrat", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 145 currency: XCD
		Country::create(array('iso_code' => 'MLT', 'name' => "Malta", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 104));//id: 146 currency: MTL
		Country::create(array('iso_code' => 'MUS', 'name' => "Mauritius", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 105));//id: 147 currency: MUR
		Country::create(array('iso_code' => 'MDV', 'name' => "Maldives", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 106));//id: 148 currency: MVR
		Country::create(array('iso_code' => 'MWI', 'name' => "Malawi", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 107));//id: 149 currency: MWK
		Country::create(array('iso_code' => 'MEX', 'name' => "Mexico", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 108));//id: 150 currency: MXN
		Country::create(array('iso_code' => 'MYS', 'name' => "Malaysia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 109));//id: 151 currency: MYR
		Country::create(array('iso_code' => 'MOZ', 'name' => "Mozambique", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 110));//id: 152 currency: MZN
		Country::create(array('iso_code' => 'NAM', 'name' => "Namibia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 173));//id: 153 currency: ZAR
		Country::create(array('iso_code' => 'NCL', 'name' => "New Caledonia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 170));//id: 154 currency: XPF
		Country::create(array('iso_code' => 'NER', 'name' => "Niger", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 155 currency: XOF
		Country::create(array('iso_code' => 'NFK', 'name' => "Norfolk Island", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 156 currency: AUD
		Country::create(array('iso_code' => 'NGA', 'name' => "Nigeria", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 111));//id: 157 currency: NGN
		Country::create(array('iso_code' => 'NIC', 'name' => "Nicaragua", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 112));//id: 158 currency: NIO
		Country::create(array('iso_code' => 'NLD', 'name' => "Netherlands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 159 currency: EUR
		Country::create(array('iso_code' => 'NOR', 'name' => "Norway", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 114));//id: 160 currency: NOK
		Country::create(array('iso_code' => 'NPL', 'name' => "Nepal", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 115));//id: 161 currency: NPR
		Country::create(array('iso_code' => 'NRU', 'name' => "Nauru", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 162 currency: AUD
		Country::create(array('iso_code' => 'NIU', 'name' => "Niue", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 116));//id: 163 currency: NZD
		Country::create(array('iso_code' => 'NZL', 'name' => "New Zealand", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 116));//id: 164 currency: NZD
		Country::create(array('iso_code' => 'OMN', 'name' => "Oman", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 117));//id: 165 currency: OMR
		Country::create(array('iso_code' => 'PAN', 'name' => "Panama", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 118));//id: 166 currency: PAB
		Country::create(array('iso_code' => 'PER', 'name' => "Peru", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 119));//id: 167 currency: PEN
		Country::create(array('iso_code' => 'PYF', 'name' => "French Polynesia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 170));//id: 168 currency: XPF
		Country::create(array('iso_code' => 'PNG', 'name' => "Papua New Guinea", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 120));//id: 169 currency: PGK
		Country::create(array('iso_code' => 'PHL', 'name' => "Philippines", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 121));//id: 170 currency: PHP
		Country::create(array('iso_code' => 'PAK', 'name' => "Pakistan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 122));//id: 171 currency: PKR
		Country::create(array('iso_code' => 'POL', 'name' => "Poland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 123));//id: 172 currency: PLN
		Country::create(array('iso_code' => 'SPM', 'name' => "Saint Pierre And Miquelon", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 173 currency: EUR
		Country::create(array('iso_code' => 'PCN', 'name' => "Pitcairn", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 174 currency:
		Country::create(array('iso_code' => 'PRI', 'name' => "Puerto Rico", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 175 currency: USD
		Country::create(array('iso_code' => 'PSE', 'name' => "Palestinian Territory Occupied", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 176 currency:
		Country::create(array('iso_code' => 'PRT', 'name' => "Portugal", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 177 currency: EUR
		Country::create(array('iso_code' => 'PLW', 'name' => "Palau", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 178 currency: USD
		Country::create(array('iso_code' => 'PRY', 'name' => "Paraguay", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 125));//id: 179 currency: PYG
		Country::create(array('iso_code' => 'QAT', 'name' => "Qatar", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 126));//id: 180 currency: QAR
		Country::create(array('iso_code' => 'REU', 'name' => "Réunion", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 181 currency: EUR
		Country::create(array('iso_code' => 'ROU', 'name' => "Romania", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 127));//id: 182 currency: ROL
		Country::create(array('iso_code' => 'SRB', 'name' => "Serbia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 129));//id: 183 currency: RSD
		Country::create(array('iso_code' => 'RUS', 'name' => "Russian Federation", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 130));//id: 184 currency: RUB
		Country::create(array('iso_code' => 'RWA', 'name' => "Rwanda", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 131));//id: 185 currency: RWF
		Country::create(array('iso_code' => 'SAU', 'name' => "Saudi Arabia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 132));//id: 186 currency: SAR
		Country::create(array('iso_code' => 'SLB', 'name' => "Solomon Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 133));//id: 187 currency: SBD
		Country::create(array('iso_code' => 'SYC', 'name' => "Seychelles", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 134));//id: 188 currency: SCR
		Country::create(array('iso_code' => 'SDN', 'name' => "Sudan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 135));//id: 189 currency: SDG
		Country::create(array('iso_code' => 'SWE', 'name' => "Sweden", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 136));//id: 190 currency: SEK
		Country::create(array('iso_code' => 'SGP', 'name' => "Singapore", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 138));//id: 191 currency: SGD
		Country::create(array('iso_code' => 'SHN', 'name' => "Saint Helena", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 139));//id: 192 currency: SHP
		Country::create(array('iso_code' => 'SVN', 'name' => "Slovenia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 193 currency: EUR
		Country::create(array('iso_code' => 'SJM', 'name' => "Svalbard And Jan Mayen", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 194 currency:
		Country::create(array('iso_code' => 'SVK', 'name' => "Slovakia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 140));//id: 195 currency: SKK
		Country::create(array('iso_code' => 'SLE', 'name' => "Sierra Leone", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 141));//id: 196 currency: SLL
		Country::create(array('iso_code' => 'SMR', 'name' => "San Marino", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 197 currency: EUR
		Country::create(array('iso_code' => 'SEN', 'name' => "Senegal", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 198 currency: XOF
		Country::create(array('iso_code' => 'SOM', 'name' => "Somalia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 142));//id: 199 currency: SOS
		Country::create(array('iso_code' => 'SUR', 'name' => "Suriname", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 143));//id: 200 currency: SRD
		Country::create(array('iso_code' => 'STP', 'name' => "Sao Tome And Principe", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 144));//id: 201 currency: STD
		Country::create(array('iso_code' => 'SLV', 'name' => "El Salvador", 'region_name' => 'State', 'region_lang_key' => 'system/country.department', 'currency_id' => 160));//id: 202 currency: SVC (145), USD (160)
		Country::create(array('iso_code' => 'SYR', 'name' => "Syrian Arab Republic", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 146));//id: 203 currency: SYP
		Country::create(array('iso_code' => 'SWZ', 'name' => "Swaziland", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 147));//id: 204 currency: SZL
		Country::create(array('iso_code' => 'TCA', 'name' => "Turks And Caicos Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 205 currency: USD
		Country::create(array('iso_code' => 'TCD', 'name' => "Chad", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 167));//id: 206 currency: XAF
		Country::create(array('iso_code' => 'ATF', 'name' => "French Southern Territories", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 207 currency:
		Country::create(array('iso_code' => 'TGO', 'name' => "Togo", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 169));//id: 208 currency: XOF
		Country::create(array('iso_code' => 'THA', 'name' => "Thailand", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 148));//id: 209 currency: THB
		Country::create(array('iso_code' => 'TJK', 'name' => "Tajikistan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 149));//id: 210 currency: TJS
		Country::create(array('iso_code' => 'TKL', 'name' => "Tokelau", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 116));//id: 211 currency: NZD
		Country::create(array('iso_code' => 'TLS', 'name' => "Timor-Leste", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 212 currency:
		Country::create(array('iso_code' => 'TKM', 'name' => "Turkmenistan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 150));//id: 213 currency: TMM
		Country::create(array('iso_code' => 'TUN', 'name' => "Tunisia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 151));//id: 214 currency: TND
		Country::create(array('iso_code' => 'TON', 'name' => "Tonga", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 152));//id: 215 currency: TOP
		Country::create(array('iso_code' => 'TUR', 'name' => "Turkey", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 154));//id: 216 currency: TRY
		Country::create(array('iso_code' => 'TTO', 'name' => "Trinidad And Tobago", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 155));//id: 217 currency: TTD
		Country::create(array('iso_code' => 'TUV', 'name' => "Tuvalu", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 9));//id: 218 currency: AUD
		Country::create(array('iso_code' => 'TWN', 'name' => "Taiwan, Province Of China", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 156));//id: 219 currency: TWD
		Country::create(array('iso_code' => 'TZA', 'name' => "Tanzania United Republic Of", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 157));//id: 220 currency: TZS
		Country::create(array('iso_code' => 'UKR', 'name' => "Ukraine", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 158));//id: 221 currency: UAH
		Country::create(array('iso_code' => 'UGA', 'name' => "Uganda", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 159));//id: 222 currency: UGX
		Country::create(array('iso_code' => 'UMI', 'name' => "United States Minor Outlying Islands", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => null));//id: 223 currency:
		Country::create(array('iso_code' => 'USA', 'name' => "United States", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 224 currency: USD
		Country::create(array('iso_code' => 'URY', 'name' => "Uruguay", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 161));//id: 225 currency: UYU
		Country::create(array('iso_code' => 'UZB', 'name' => "Uzbekistan", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 162));//id: 226 currency: UZS
		Country::create(array('iso_code' => 'VAT', 'name' => "Holy See (Vatican City State)", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 227 currency: EUR
		Country::create(array('iso_code' => 'VCT', 'name' => "Saint Vincent And The Grenadines", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 168));//id: 228 currency: XCD
		Country::create(array('iso_code' => 'VEN', 'name' => "Venezuela", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 163));//id: 229 currency: VEB
		Country::create(array('iso_code' => 'VGB', 'name' => "Virgin Islands British", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 230 currency: USD
		Country::create(array('iso_code' => 'VIR', 'name' => "Virgin Islands U.S.", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 160));//id: 231 currency: USD
		Country::create(array('iso_code' => 'VNM', 'name' => "Viet Nam", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 164));//id: 232 currency: VND
		Country::create(array('iso_code' => 'VUT', 'name' => "Vanuatu", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 165));//id: 233 currency: VUV
		Country::create(array('iso_code' => 'WLF', 'name' => "Wallis And Futuna", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 170));//id: 234 currency: XPF
		Country::create(array('iso_code' => 'WSM', 'name' => "Samoa", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 166));//id: 235 currency: WST
		Country::create(array('iso_code' => 'YEM', 'name' => "Yemen", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 171));//id: 236 currency: YER
		Country::create(array('iso_code' => 'MYT', 'name' => "Mayotte", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 50));//id: 237 currency: EUR
		Country::create(array('iso_code' => 'ZAF', 'name' => "South Africa", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 173));//id: 238 currency: ZAR
		Country::create(array('iso_code' => 'ZMB', 'name' => "Zambia", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 174));//id: 239 currency: ZMK
		Country::create(array('iso_code' => 'ZWE', 'name' => "Zimbabwe", 'region_name' => 'State', 'region_lang_key' => 'system/country.state', 'currency_id' => 175));//id: 240 currency: ZWD
	}

}

<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Seeder;
use App\Kwaai\System\Region;

class RegionTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SYS_Region')->delete();

		//Canada
		Region::create(array('name' => "Alberta", 'region_code' => '', 'country_id' => 36));//id: 1
		Region::create(array('name' => "British Columbia", 'region_code' => '', 'country_id' => 36));//id: 2
		Region::create(array('name' => "Manitoba", 'region_code' => '', 'country_id' => 36));//id: 3
		Region::create(array('name' => "New Brunswick", 'region_code' => '', 'country_id' => 36));//id: 4
		Region::create(array('name' => "Newfoundland and Labrador", 'region_code' => '', 'country_id' => 36));//id: 5
		Region::create(array('name' => "Nova Scotia", 'region_code' => '', 'country_id' => 36));//id: 6
		Region::create(array('name' => "Northwest Territories", 'region_code' => '', 'country_id' => 36));//id: 7
		Region::create(array('name' => "Nunavut", 'region_code' => '', 'country_id' => 36));//id: 8
		Region::create(array('name' => "Ontario", 'region_code' => '', 'country_id' => 36));//id: 9
		Region::create(array('name' => "Prince Edward Island", 'region_code' => '', 'country_id' => 36));//id: 10
		Region::create(array('name' => "Québec", 'region_code' => '', 'country_id' => 36));//id: 11
		Region::create(array('name' => "Saskatchewan", 'region_code' => '', 'country_id' => 36));//id: 12
		Region::create(array('name' => "Yukon", 'region_code' => '', 'country_id' => 36));//id: 13

		//United Kingdom
		Region::create(array('name' => "Avon", 'region_code' => '', 'country_id' => 74));//id: 14
		Region::create(array('name' => "Befordshire", 'region_code' => '', 'country_id' => 74));//id: 15
		Region::create(array('name' => "Buckinghamshire", 'region_code' => '', 'country_id' => 74));//id: 16
		Region::create(array('name' => "Cambridgeshire", 'region_code' => '', 'country_id' => 74));//id: 17
		Region::create(array('name' => "Cheshire", 'region_code' => '', 'country_id' => 74));//id: 18
		Region::create(array('name' => "Cleveland", 'region_code' => '', 'country_id' => 74));//id: 19
		Region::create(array('name' => "Cornwall", 'region_code' => '', 'country_id' => 74));//id: 20
		Region::create(array('name' => "Cumbria", 'region_code' => '', 'country_id' => 74));//id: 21
		Region::create(array('name' => "Derbyshire", 'region_code' => '', 'country_id' => 74));//id: 22
		Region::create(array('name' => "Devon", 'region_code' => '', 'country_id' => 74));//id: 23
		Region::create(array('name' => "Dorset", 'region_code' => '', 'country_id' => 74));//id: 24
		Region::create(array('name' => "Durham", 'region_code' => '', 'country_id' => 74));//id: 25
		Region::create(array('name' => "East Sussex", 'region_code' => '', 'country_id' => 74));//id: 26
		Region::create(array('name' => "Essex", 'region_code' => '', 'country_id' => 74));//id: 27
		Region::create(array('name' => "Gloucestershire", 'region_code' => '', 'country_id' => 74));//id: 28
		Region::create(array('name' => "Greater London", 'region_code' => '', 'country_id' => 74));//id: 29
		Region::create(array('name' => "Greater Manchester", 'region_code' => '', 'country_id' => 74));//id: 30
		Region::create(array('name' => "Hampshire", 'region_code' => '', 'country_id' => 74));//id: 31
		Region::create(array('name' => "Herefordshire", 'region_code' => '', 'country_id' => 74));//id: 32
		Region::create(array('name' => "Hertfordshire", 'region_code' => '', 'country_id' => 74));//id: 33
		Region::create(array('name' => "Humberside", 'region_code' => '', 'country_id' => 74));//id: 34
		Region::create(array('name' => "Isle of Wight", 'region_code' => '', 'country_id' => 74));//id: 35
		Region::create(array('name' => "Kent", 'region_code' => '', 'country_id' => 74));//id: 36
		Region::create(array('name' => "Lancashire", 'region_code' => '', 'country_id' => 74));//id: 37
		Region::create(array('name' => "Lincolnshire", 'region_code' => '', 'country_id' => 74));//id: 38
		Region::create(array('name' => "Merseyside", 'region_code' => '', 'country_id' => 74));//id: 39
		Region::create(array('name' => "Norfolk", 'region_code' => '', 'country_id' => 74));//id: 40
		Region::create(array('name' => "Northamtonshire", 'region_code' => '', 'country_id' => 74));//id: 41
		Region::create(array('name' => "Northumberland", 'region_code' => '', 'country_id' => 74));//id: 42
		Region::create(array('name' => "North Yorkshire", 'region_code' => '', 'country_id' => 74));//id: 43
		Region::create(array('name' => "Nottinghamshire", 'region_code' => '', 'country_id' => 74));//id: 44
		Region::create(array('name' => "Oxfordshire", 'region_code' => '', 'country_id' => 74));//id: 45
		Region::create(array('name' => "Shropshire", 'region_code' => '', 'country_id' => 74));//id: 46
		Region::create(array('name' => "Somerset", 'region_code' => '', 'country_id' => 74));//id: 47
		Region::create(array('name' => "South Yorkshire", 'region_code' => '', 'country_id' => 74));//id: 48
		Region::create(array('name' => "Staffordshire", 'region_code' => '', 'country_id' => 74));//id: 49
		Region::create(array('name' => "Suffolk", 'region_code' => '', 'country_id' => 74));//id: 50
		Region::create(array('name' => "Surrey", 'region_code' => '', 'country_id' => 74));//id: 51
		Region::create(array('name' => "Tyne and Wear", 'region_code' => '', 'country_id' => 74));//id: 52
		Region::create(array('name' => "Warwickshire", 'region_code' => '', 'country_id' => 74));//id: 53
		Region::create(array('name' => "West Midlands", 'region_code' => '', 'country_id' => 74));//id: 54
		Region::create(array('name' => "West Sussex", 'region_code' => '', 'country_id' => 74));//id: 55
		Region::create(array('name' => "West Yorkshire", 'region_code' => '', 'country_id' => 74));//id: 56
		Region::create(array('name' => "Wiltshire", 'region_code' => '', 'country_id' => 74));//id: 57
		Region::create(array('name' => "Worcestershire", 'region_code' => '', 'country_id' => 74));//id: 58
		Region::create(array('name' => "Borders", 'region_code' => '', 'country_id' => 74));//id: 59
		Region::create(array('name' => "Central (Scotland)", 'region_code' => '', 'country_id' => 74));//id: 60
		Region::create(array('name' => "Dumfries and Galloway", 'region_code' => '', 'country_id' => 74));//id: 61
		Region::create(array('name' => "Fife", 'region_code' => '', 'country_id' => 74));//id: 62
		Region::create(array('name' => "Grampian", 'region_code' => '', 'country_id' => 74));//id: 63
		Region::create(array('name' => "Highland", 'region_code' => '', 'country_id' => 74));//id: 64
		Region::create(array('name' => "Lothian", 'region_code' => '', 'country_id' => 74));//id: 74
		Region::create(array('name' => "Orkney", 'region_code' => '', 'country_id' => 74));//id: 66
		Region::create(array('name' => "Shetland", 'region_code' => '', 'country_id' => 74));//id: 67
		Region::create(array('name' => "Strathclyde", 'region_code' => '', 'country_id' => 74));//id: 68
		Region::create(array('name' => "Tayside", 'region_code' => '', 'country_id' => 74));//id: 69
		Region::create(array('name' => "Western Isles", 'region_code' => '', 'country_id' => 74));//id: 70
		Region::create(array('name' => "Clwyd", 'region_code' => '', 'country_id' => 74));//id: 71
		Region::create(array('name' => "Dyfed", 'region_code' => '', 'country_id' => 74));//id: 72
		Region::create(array('name' => "Gwent", 'region_code' => '', 'country_id' => 74));//id: 73
		Region::create(array('name' => "Gwynedd", 'region_code' => '', 'country_id' => 74));//id: 74
		Region::create(array('name' => "Mid Glamorgan", 'region_code' => '', 'country_id' => 74));//id: 75
		Region::create(array('name' => "Powys", 'region_code' => '', 'country_id' => 74));//id: 76
		Region::create(array('name' => "South Glamorgan", 'region_code' => '', 'country_id' => 74));//id: 77
		Region::create(array('name' => "West Glamorgan", 'region_code' => '', 'country_id' => 74));//id: 78
		Region::create(array('name' => "Antrim (NI)", 'region_code' => '', 'country_id' => 74));//id: 79
		Region::create(array('name' => "Ards (NI)", 'region_code' => '', 'country_id' => 74));//id: 80
		Region::create(array('name' => "Armagh (NI)", 'region_code' => '', 'country_id' => 74));//id: 81
		Region::create(array('name' => "Ballymena (NI)", 'region_code' => '', 'country_id' => 74));//id: 82
		Region::create(array('name' => "Ballymoney (NI)", 'region_code' => '', 'country_id' => 74));//id: 83
		Region::create(array('name' => "Banbridge (NI)", 'region_code' => '', 'country_id' => 74));//id: 84
		Region::create(array('name' => "Belfast (NI)", 'region_code' => '', 'country_id' => 74));//id: 85
		Region::create(array('name' => "Carrickfergus (NI)", 'region_code' => '', 'country_id' => 74));//id: 86
		Region::create(array('name' => "Castlereagh (NI)", 'region_code' => '', 'country_id' => 74));//id: 87
		Region::create(array('name' => "Coleraine (NI)", 'region_code' => '', 'country_id' => 74));//id: 88
		Region::create(array('name' => "Cookstown (NI)", 'region_code' => '', 'country_id' => 74));//id: 89
		Region::create(array('name' => "Craigavon (NI)", 'region_code' => '', 'country_id' => 74));//id: 90
		Region::create(array('name' => "Down (NI)", 'region_code' => '', 'country_id' => 74));//id: 91
		Region::create(array('name' => "Dungannon (NI)", 'region_code' => '', 'country_id' => 74));//id: 92
		Region::create(array('name' => "Fermanagh (NI)", 'region_code' => '', 'country_id' => 74));//id: 93
		Region::create(array('name' => "Larne (NI)", 'region_code' => '', 'country_id' => 74));//id: 94
		Region::create(array('name' => "Limavady (NI)", 'region_code' => '', 'country_id' => 74));//id: 95
		Region::create(array('name' => "Lisburn (NI)", 'region_code' => '', 'country_id' => 74));//id: 96
		Region::create(array('name' => "Londonderry (NI)", 'region_code' => '', 'country_id' => 74));//id: 97
		Region::create(array('name' => "Magherafelt (NI)", 'region_code' => '', 'country_id' => 74));//id: 98
		Region::create(array('name' => "Moyle (NI)", 'region_code' => '', 'country_id' => 74));//id: 99
		Region::create(array('name' => "Newry and Mourne (NI)", 'region_code' => '', 'country_id' => 74));//id: 100
		Region::create(array('name' => "Newtonabbey (NI)", 'region_code' => '', 'country_id' => 74));//id: 101
		Region::create(array('name' => "North Down (NI)", 'region_code' => '', 'country_id' => 74));//id: 102
		Region::create(array('name' => "Omagh (NI)", 'region_code' => '', 'country_id' => 74));//id: 103
		Region::create(array('name' => "Strabane (NI)", 'region_code' => '', 'country_id' => 74));//id: 104
		Region::create(array('name' => "Alderney (CI)", 'region_code' => '', 'country_id' => 74));//id: 105
		Region::create(array('name' => "Guernsey (CI)", 'region_code' => '', 'country_id' => 74));//id: 106
		Region::create(array('name' => "Jersey (CI)", 'region_code' => '', 'country_id' => 74));//id: 107
		Region::create(array('name' => "Isle of Man", 'region_code' => '', 'country_id' => 74));//id: 108

		//United State
		Region::create(array('name' => "Connecticut", 'region_code' => '', 'country_id' => 224));//id: 109
		Region::create(array('name' => "California", 'region_code' => '', 'country_id' => 224));//id: 110
		Region::create(array('name' => "Massachusetts", 'region_code' => '', 'country_id' => 224));//id: 111
		Region::create(array('name' => "Maine", 'region_code' => '', 'country_id' => 224));//id: 112
		Region::create(array('name' => "New Hampshire", 'region_code' => '', 'country_id' => 224));//id: 113
		Region::create(array('name' => "Rhode Island", 'region_code' => '', 'country_id' => 224));//id: 114
		Region::create(array('name' => "New York", 'region_code' => '', 'country_id' => 224));//id: 115
		Region::create(array('name' => "New Jersey", 'region_code' => '', 'country_id' => 224));//id: 116
		Region::create(array('name' => "Pennsylvania", 'region_code' => '', 'country_id' => 224));//id: 117
		Region::create(array('name' => "Virginia", 'region_code' => '', 'country_id' => 224));//id: 118
		Region::create(array('name' => "West Virginia", 'region_code' => '', 'country_id' => 224));//id: 119
		Region::create(array('name' => "Florida", 'region_code' => '', 'country_id' => 224));//id: 120
		Region::create(array('name' => "Alabama", 'region_code' => '', 'country_id' => 224));//id: 121
		Region::create(array('name' => "Deleware", 'region_code' => '', 'country_id' => 224));//id: 122
		Region::create(array('name' => "Washington", 'region_code' => '', 'country_id' => 224));//id: 123
		Region::create(array('name' => "Alaska", 'region_code' => '', 'country_id' => 224));//id: 124
		Region::create(array('name' => "Tennessee", 'region_code' => '', 'country_id' => 224));//id: 125
		Region::create(array('name' => "Georgia", 'region_code' => '', 'country_id' => 224));//id: 126
		Region::create(array('name' => "North Dakota", 'region_code' => '', 'country_id' => 224));//id: 127
		Region::create(array('name' => "South Dakato", 'region_code' => '', 'country_id' => 224));//id: 128
		Region::create(array('name' => "Michigan", 'region_code' => '', 'country_id' => 224));//id: 129
		Region::create(array('name' => "Iowa", 'region_code' => '', 'country_id' => 224));//id: 130
		Region::create(array('name' => "Indiana", 'region_code' => '', 'country_id' => 224));//id: 131
		Region::create(array('name' => "Ohio", 'region_code' => '', 'country_id' => 224));//id: 132
		Region::create(array('name' => "Illinois", 'region_code' => '', 'country_id' => 224));//id: 133
		Region::create(array('name' => "South Carolina", 'region_code' => '', 'country_id' => 224));//id: 134
		Region::create(array('name' => "North Carolina", 'region_code' => '', 'country_id' => 224));//id: 135
		Region::create(array('name' => "Kentucky", 'region_code' => '', 'country_id' => 224));//id: 136
		Region::create(array('name' => "Lousiana", 'region_code' => '', 'country_id' => 224));//id: 137
		Region::create(array('name' => "Texas", 'region_code' => '', 'country_id' => 224));//id: 138
		Region::create(array('name' => "Oklahoma", 'region_code' => '', 'country_id' => 224));//id: 139
		Region::create(array('name' => "Mississippi", 'region_code' => '', 'country_id' => 224));//id: 140
		Region::create(array('name' => "Montana", 'region_code' => '', 'country_id' => 224));//id: 141
		Region::create(array('name' => "Missouri", 'region_code' => '', 'country_id' => 224));//id: 142
		Region::create(array('name' => "Kansas", 'region_code' => '', 'country_id' => 224));//id: 143
		Region::create(array('name' => "Nebraska", 'region_code' => '', 'country_id' => 224));//id: 144
		Region::create(array('name' => "Wyoming", 'region_code' => '', 'country_id' => 224));//id: 145
		Region::create(array('name' => "New Mexico", 'region_code' => '', 'country_id' => 224));//id: 146
		Region::create(array('name' => "Oregon", 'region_code' => '', 'country_id' => 224));//id: 147
		Region::create(array('name' => "Arkansas", 'region_code' => '', 'country_id' => 224));//id: 148
		Region::create(array('name' => "Arizona", 'region_code' => '', 'country_id' => 224));//id: 149
		Region::create(array('name' => "Utah", 'region_code' => '', 'country_id' => 224));//id: 150
		Region::create(array('name' => "Idaho", 'region_code' => '', 'country_id' => 224));//id: 151
		Region::create(array('name' => "Nevada", 'region_code' => '', 'country_id' => 224));//id: 152
		Region::create(array('name' => "Colorado", 'region_code' => '', 'country_id' => 224));//id: 153
		Region::create(array('name' => "Hawaii", 'region_code' => '', 'country_id' => 224));//id: 154
		Region::create(array('name' => "Minnesota", 'region_code' => '', 'country_id' => 224));//id: 155
		Region::create(array('name' => "Wisconsin", 'region_code' => '', 'country_id' => 224));//id: 156
		Region::create(array('name' => "Maryland", 'region_code' => '', 'country_id' => 224));//id: 157
		Region::create(array('name' => "Vermont", 'region_code' => '', 'country_id' => 224));//id: 158

		//El Salvador
		Region::create(array('name' => "Ahuachapán", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Cabañas", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Chalatenango", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Cuscatlán", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "La Libertad", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "La Paz", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "La Unión", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Morazán", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Santa Ana", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "San Miguel", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "San Salvador", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "San Vicente", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Sonsonate", 'region_code' => '', 'country_id' => 202));//id: 159
		Region::create(array('name' => "Usulután", 'region_code' => '', 'country_id' => 202));//id: 159
	}

}

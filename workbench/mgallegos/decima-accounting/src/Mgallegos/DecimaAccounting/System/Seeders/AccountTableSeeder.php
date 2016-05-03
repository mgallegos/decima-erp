<?php
/**
 * @file
 * SEC_User Table Seeder
 *
 * All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\DecimaAccounting\System\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Mgallegos\DecimaAccounting\System\Account;

class AccountTableSeeder extends Seeder {

	public function run()
	{
		DB::table('SYS_Account')->delete();

		Account::create(array('name' => 'Activo', 'key' => '1', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Activo Corriente', 'key' => '1.1', 'parent_key' => '1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Caja y Bancos', 'key' => '1.1.01', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Caja Chica', 'key' => '1.1.01.01', 'parent_key' => '1.1.01', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Efectivo', 'key' => '1.1.01.02', 'parent_key' => '1.1.01', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Banco', 'key' => '1.1.01.03', 'parent_key' => '1.1.01', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Cuentas y Documentos por Cobrar', 'key' => '1.1.02', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Cuentas por Cobrar Generales', 'key' => '1.1.02.01', 'parent_key' => '1.1.02', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Cuentas por Cobrar Empresas Afilidas', 'key' => '1.1.02.02', 'parent_key' => '1.1.02', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Prestamos al Personal', 'key' => '1.1.02.03', 'parent_key' => '1.1.02', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otras Cuentas por Cobrar', 'key' => '1.1.02.04', 'parent_key' => '1.1.02', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Impuestos', 'key' => '1.1.03', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'IVA Credito fiscal', 'key' => '1.1.03.01', 'parent_key' => '1.1.03', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Retenciones de IVA recibidas', 'key' => '1.1.03.02', 'parent_key' => '1.1.03', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Inventario', 'key' => '1.1.04', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Inventario', 'key' => '1.1.04.01', 'parent_key' => '1.1.04', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'No Corriente', 'key' => '1.2', 'parent_key' => '1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Propiedad, Planta y Equipo', 'key' => '1.2.01', 'parent_key' => '1.2', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Propiedad, Planta y Equipo', 'key' => '1.2.01.01', 'parent_key' => '1.2.01', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Depreciaciones Acumuladas', 'key' => '1.2.02', 'parent_key' => '1.2', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Depreciaciones Acumuladas', 'key' => '1.2.02.01', 'parent_key' => '1.2.02', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Diferido', 'key' => '1.3', 'parent_key' => '1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos por Amortizar', 'key' => '1.3.01', 'parent_key' => '1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos por Amortizar', 'key' => '1.3.01.01', 'parent_key' => '1.3.01', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos Anticipados', 'key' => '1.3.02', 'parent_key' => '1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos Anticipados', 'key' => '1.3.02.01', 'parent_key' => '1.3.02', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Organización', 'key' => '1.3.03', 'parent_key' => '1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Organización', 'key' => '1.3.03.01', 'parent_key' => '1.3.03', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Activos', 'key' => '1.3.04', 'parent_key' => '1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Activos', 'key' => '1.3.04.01', 'parent_key' => '1.3.04', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Pasivo', 'key' => '2', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Pasivo Corto Plazo', 'key' => '2.1', 'parent_key' => '2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Cuentas y Documentos por Pagar', 'key' => '2.1.01', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Cuentas y Documentos por Pagar', 'key' => '2.1.01.01', 'parent_key' => '2.1.01', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'IVA por Pagar', 'key' => '2.1.02', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'IVA por Pagar', 'key' => '2.1.02.01', 'parent_key' => '2.1.02', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'IVA Debito fiscal', 'key' => '2.1.02.02', 'parent_key' => '2.1.02', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Impuestos', 'key' => '2.1.03', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Impuesto sobre la renta', 'key' => '2.1.03.01', 'parent_key' => '2.1.03', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros  Impuestos', 'key' => '2.1.03.02', 'parent_key' => '2.1.03', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Pasivo a Largo Plazo', 'key' => '2.2', 'parent_key' => '2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Provisión para Indemnizaciones', 'key' => '2.2.01', 'parent_key' => '2.2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Provisión para Indemnizaciones', 'key' => '2.2.01.01', 'parent_key' => '2.2.01', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Créditos Diferidos', 'key' => '2.3', 'parent_key' => '2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Créditos Diferidos', 'key' => '2.3.01', 'parent_key' => '2.3', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Anticipos', 'key' => '2.3.01.01', 'parent_key' => '2.3.01', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Patrimonio', 'key' => '3', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Patrimonio de los Accionistas', 'key' => '3.1', 'parent_key' => '3', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Patrimonio de los Accionistas', 'key' => '3.1.01', 'parent_key' => '3.1', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Capital Autorizado, Suscríto y Pagado', 'key' => '3.1.01.01', 'parent_key' => '3.1.01', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Reservas', 'key' => '3.1.01.02', 'parent_key' => '3.1.01', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Perdidas y Ganancias', 'key' => '3.1.01.03', 'parent_key' => '3.1.01', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Ingresos', 'key' => '4', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Ventas', 'key' => '4.1', 'parent_key' => '4', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Ventas Netas', 'key' => '4.1.01', 'parent_key' => '4.1', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Ventas', 'key' => '4.1.01.01', 'parent_key' => '4.1.01', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Descuentos Sobre Ventas', 'key' => '4.1.01.02', 'parent_key' => '4.1.01', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Ingresos financieros', 'key' => '4.2', 'parent_key' => '4', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Intereses', 'key' => '4.2.01', 'parent_key' => '4.2', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Interes por depositos bancarios', 'key' => '4.2.01.01', 'parent_key' => '4.2.01', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Ingresos', 'key' => '4,9', 'parent_key' => '4', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Ingresos', 'key' => '4.9.01', 'parent_key' => '4,9', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Ingresos', 'key' => '4.9.01.01', 'parent_key' => '4.9.01', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Egresos', 'key' => '5', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Costos', 'key' => '5.1', 'parent_key' => '5', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Costos de Ventas', 'key' => '5.1.01', 'parent_key' => '5.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Costos de Ventas', 'key' => '5.1.01.01', 'parent_key' => '5.1.01', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos', 'key' => '6', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Ventas', 'key' => '6.1', 'parent_key' => '6', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Ventas', 'key' => '6.1.01', 'parent_key' => '6.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Ventas', 'key' => '6.1.01.01', 'parent_key' => '6.1.01', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Operación', 'key' => '6.2', 'parent_key' => '6', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Administración', 'key' => '6.2.01', 'parent_key' => '6.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos de Administración', 'key' => '6.2.01.01', 'parent_key' => '6.2.01', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Gastos de Operación', 'key' => '6.2.02', 'parent_key' => '6.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Gastos de Operación', 'key' => '6.2.02.01', 'parent_key' => '6.2.02', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos no Deducibles', 'key' => '6.3', 'parent_key' => '6', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos no Deducibles', 'key' => '6.3.01', 'parent_key' => '6.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos no Deducibles', 'key' => '6.3.01.01', 'parent_key' => '6.3.01', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos  Financieros', 'key' => '7', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos  Financieros', 'key' => '7.1', 'parent_key' => '7', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Gastos  Financieros', 'key' => '7.1.01', 'parent_key' => '7.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Intereses', 'key' => '7.1.01.01', 'parent_key' => '7.1.01', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 1));
		Account::create(array('name' => 'Otros Gastos Financieros', 'key' => '7.1.01.02', 'parent_key' => '7.1.01', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 1));

	}

}

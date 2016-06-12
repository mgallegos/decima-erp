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
use Mgallegos\DecimaAccounting\System\AccountChartType;
use Mgallegos\DecimaAccounting\System\Account;

class UcaAccountSlvTableSeeder extends Seeder {

	public function run()
	{
		// AccountChartType::create(array('name' => 'Contabilidad de Costos I', 'url' => 'https://docs.google.com/spreadsheets/d/1kiZhrpwA5oLGWftY20DnnnY-OEcYGYmjCQBo1VxVNJ0/edit?usp=sharing', 'lang_key' => 'decima-accounting::account-chart-type.ucaCostos', 'country_id' => 202));//2

		Account::create(array('name' => 'Activo', 'key' => '1', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Activo Corriente', 'key' => '1.1', 'parent_key' => '1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Efectivo y Equivalentes', 'key' => '1.1.1', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Caja General', 'key' => '1.1.1.1', 'parent_key' => '1.1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Caja Chica', 'key' => '1.1.1.2', 'parent_key' => '1.1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Bancos', 'key' => '1.1.1.3', 'parent_key' => '1.1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Inversiones (Vencimiento menor a 90 días)', 'key' => '1.1.1.3', 'parent_key' => '1.1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Cuentas por Cobrar', 'key' => '1.1.2', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Clientes', 'key' => '1.1.2.1', 'parent_key' => '1.1.2', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Inventarios', 'key' => '1.1.3', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Materiales', 'key' => '1.1.3.1', 'parent_key' => '1.1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Producción en Proceso', 'key' => '1.1.3.2', 'parent_key' => '1.1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Material Directo', 'key' => '1.1.3.2.1', 'parent_key' => '1.1.3.2', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Mano de Obra Directa', 'key' => '1.1.3.2.2', 'parent_key' => '1.1.3.2', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Costos Indirectos de Fabricación Estimados', 'key' => '1.1.3.2.3', 'parent_key' => '1.1.3.2', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aplicación de Costos Indirectos de Fabricación(cr)', 'key' => '1.1.3.3', 'parent_key' => '1.1.3', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Artículos Terminados', 'key' => '1.1.3.4', 'parent_key' => '1.1.3', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA Crédito Fiscal', 'key' => '1.1.4', 'parent_key' => '1.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA Crédito Fiscal-Compras Locales', 'key' => '1.1.4.1', 'parent_key' => '1.1.4', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA Crédito Fiscal-Importación', 'key' => '1.1.4.2', 'parent_key' => '1.1.4', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA - Retención 1%', 'key' => '1.1.4.3', 'parent_key' => '1.1.4', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA - Percepción 1%', 'key' => '1.1.4.4', 'parent_key' => '1.1.4', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA - Remanente', 'key' => '1.1.4.5', 'parent_key' => '1.1.4', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Activo No Corriente', 'key' => '1.2', 'parent_key' => '1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Propiedades, Planta y Equipo', 'key' => '1.2.1', 'parent_key' => '1.2', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Terrenos', 'key' => '1.2.1.1', 'parent_key' => '1.2.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Edificios e Instalaciones', 'key' => '1.2.1.2', 'parent_key' => '1.2.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Vehículos', 'key' => '1.2.1.3', 'parent_key' => '1.2.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Maquinaria de Producción', 'key' => '1.2.1.4', 'parent_key' => '1.2.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Equipo Informático', 'key' => '1.2.1.5', 'parent_key' => '1.2.1', 'balance_type' => 'D', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Acumulada', 'key' => '1.2.9', 'parent_key' => '1.2', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Acumulada - Edificios e Instalaciones', 'key' => '1.2.9.1', 'parent_key' => '1.2.9', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Acumulada - Vehículos', 'key' => '1.2.9.2', 'parent_key' => '1.2.9', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Acumulada - Maquinaria de Producción', 'key' => '1.2.9.3', 'parent_key' => '1.2.9', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Acumulada - Equipo Informático y de Oficina', 'key' => '1.2.9.4', 'parent_key' => '1.2.9', 'balance_type' => 'A', 'account_type_key' => 'A', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Pasivo', 'key' => '2', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Pasivo Corriente', 'key' => '2.1', 'parent_key' => '2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Proveedores', 'key' => '2.1.1', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Proveedores Locales', 'key' => '2.1.1.1', 'parent_key' => '2.1.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Proveedores del Exterior', 'key' => '2.1.1.2', 'parent_key' => '2.1.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Acreedores Diversos', 'key' => '2.1.2', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Salarios Líquidos', 'key' => '2.1.2.1', 'parent_key' => '2.1.2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Retenciones Impuesto Sobre la Renta', 'key' => '2.1.2.2', 'parent_key' => '2.1.2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aportes Laborales ISSS', 'key' => '2.1.2.3', 'parent_key' => '2.1.2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aportes Laborales AFP', 'key' => '2.1.2.4', 'parent_key' => '2.1.2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Beneficios a Empleados', 'key' => '2.1.3', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aportes Patronales ISSS', 'key' => '2.1.3.1', 'parent_key' => '2.1.3', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aportes Patronales AFP', 'key' => '2.1.3.2', 'parent_key' => '2.1.3', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA Débito Fiscal', 'key' => '2.1.4', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'IVA Débito Fiscal', 'key' => '2.1.4.1', 'parent_key' => '2.1.4', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Préstamos Corto Plazo', 'key' => '2.1.5', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Préstamos a Corto Plazo', 'key' => '2.1.5.1', 'parent_key' => '2.1.5', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Porción Corriente Préstamos Largo Plazo', 'key' => '2.1.6', 'parent_key' => '2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Porción Corriente Préstamos Largo Plazo', 'key' => '2.1.6.1', 'parent_key' => '2.1.6', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Pasivo No Corriente', 'key' => '2.2', 'parent_key' => '2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Préstamos Largo Plazo', 'key' => '2.2.1', 'parent_key' => '2.2', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Préstamos a Largo Plazo', 'key' => '2.2.1.1', 'parent_key' => '2.2.1', 'balance_type' => 'A', 'account_type_key' => 'P', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Patrimonio', 'key' => '3', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Capital Social', 'key' => '3.1', 'parent_key' => '3', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Capital Social Suscrito', 'key' => '3.1.1', 'parent_key' => '3.1', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Capital Social Suscrito', 'key' => '3.1.1.1', 'parent_key' => '3.1.1', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Capital Social Suscrito No Pagado (Cr)', 'key' => '3.1.2', 'parent_key' => '3.1', 'balance_type' => 'D', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Capital Social Suscrito No Pagado (Cr)', 'key' => '3.1.2.1', 'parent_key' => '3.1.2', 'balance_type' => 'D', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Resultados Acumulados', 'key' => '3.2', 'parent_key' => '3', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Resultado Ejercicio Corriente', 'key' => '3.2.1', 'parent_key' => '3.2', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Resultado Ejercicio Corriente', 'key' => '3.2.1.1', 'parent_key' => '3.2.1', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Resultados Ejercicios Anteriores', 'key' => '3.2.2', 'parent_key' => '3.2', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Resultados Ejercicios Anteriores', 'key' => '3.2.2.1', 'parent_key' => '3.2.2', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Reservas', 'key' => '3.3', 'parent_key' => '3', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Reserva Legal', 'key' => '3.3.1', 'parent_key' => '3.3', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Reserva Legal', 'key' => '3.3.1.1', 'parent_key' => '3.3.1', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Otras Reservas', 'key' => '3.3.2', 'parent_key' => '3.3', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Reserva Laboral', 'key' => '3.3.2.1', 'parent_key' => '3.3.2', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Otras Reservas', 'key' => '3.3.2.9', 'parent_key' => '3.3.2', 'balance_type' => 'A', 'account_type_key' => 'K', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Costos', 'key' => '4', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Costo de Ventas', 'key' => '4.1', 'parent_key' => '4', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Costo de Ventas', 'key' => '4.1.1', 'parent_key' => '4.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Costo de Ventas', 'key' => '4.1.1.1', 'parent_key' => '4.1.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Costos Indirectos de Fabricación', 'key' => '4.2', 'parent_key' => '4', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Control de Costos Indirectos de Fabricación', 'key' => '4.2.1', 'parent_key' => '4.2', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Materiales Indirectos', 'key' => '4.2.1.1', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Mano de Obra Indirecta', 'key' => '4.2.1.2', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Equipo de Producción', 'key' => '4.2.1.3', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Planta Productiva', 'key' => '4.2.1.4', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Energía Eléctrica', 'key' => '4.2.1.5', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Agua Potable', 'key' => '4.2.1.6', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Arrendamiento', 'key' => '4.2.1.7', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Mantenimiento', 'key' => '4.2.1.8', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Transporte', 'key' => '4.2.1.9', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Fletes', 'key' => '4.2.1.10', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Almacenamiento', 'key' => '4.2.1.11', 'parent_key' => '4.2.1', 'balance_type' => 'D', 'account_type_key' => 'C', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Gastos', 'key' => '5', 'parent_key' => '', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Gastos de Administración', 'key' => '5.1', 'parent_key' => '5', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Remuneraciones', 'key' => '5.1.1', 'parent_key' => '5.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Sueldos', 'key' => '5.1.1.1', 'parent_key' => '5.1.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Horas Extraordinarias', 'key' => '5.1.1.2', 'parent_key' => '5.1.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aporte Patronal ISSS', 'key' => '5.1.1.3', 'parent_key' => '5.1.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aporte Patronal AFP', 'key' => '5.1.1.4', 'parent_key' => '5.1.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aporte Patronal INSAFORP', 'key' => '5.1.1.5', 'parent_key' => '5.1.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Indemnizaciones', 'key' => '5.1.1.6', 'parent_key' => '5.1.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Bienes y Servicios', 'key' => '5.1.2', 'parent_key' => '5.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Papelería y Materiales de Oficina', 'key' => '5.1.2.1', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Libros y textos impresos', 'key' => '5.1.2.2', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Artículos Informáticos', 'key' => '5.1.2.3', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Combustible y Lubricantes', 'key' => '5.1.2.4', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Energía Eléctrica', 'key' => '5.1.2.5', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Agua Potable', 'key' => '5.1.2.6', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Arrendamiento', 'key' => '5.1.2.7', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Telefonía e Internet', 'key' => '5.1.2.8', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Mantenimiento', 'key' => '5.1.2.9', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Correo y Mensajería', 'key' => '5.1.2.10', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Vigilancia', 'key' => '5.1.2.11', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Limpieza', 'key' => '5.1.2.12', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Publicidad', 'key' => '5.1.2.13', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Viáticos', 'key' => '5.1.2.14', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Servicios Jurídicos', 'key' => '5.1.2.15', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Servicios de Contabilidad y Auditoría', 'key' => '5.1.2.16', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Servicios de Capacitación', 'key' => '5.1.2.17', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Consultorías y estudios diversos', 'key' => '5.1.2.18', 'parent_key' => '5.1.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciaciones y Amortizaciones', 'key' => '5.1.3', 'parent_key' => '5.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Edificio', 'key' => '5.1.3.1', 'parent_key' => '5.1.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Equipo de Oficina', 'key' => '5.1.3.2', 'parent_key' => '5.1.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Equipo Informático', 'key' => '5.1.3.3', 'parent_key' => '5.1.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Gastos de Venta', 'key' => '5.2', 'parent_key' => '5', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Remuneraciones', 'key' => '5.2.1', 'parent_key' => '5.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Sueldos', 'key' => '5.2.1.1', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Horas Extraordinarias', 'key' => '5.2.1.2', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aporte Patronal ISSS', 'key' => '5.2.1.3', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aporte Patronal AFP', 'key' => '5.2.1.4', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Aporte Patronal INSAFORP', 'key' => '5.2.1.5', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Indemnizaciones', 'key' => '5.2.1.6', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Comisiones', 'key' => '5.2.1.7', 'parent_key' => '5.2.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Bienes y Servicios', 'key' => '5.2.2', 'parent_key' => '5.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Papelería y Materiales de Oficina', 'key' => '5.2.2.1', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Libros y textos impresos', 'key' => '5.2.2.2', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Artículos Informáticos', 'key' => '5.2.2.3', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Combustible y Lubricantes', 'key' => '5.2.2.4', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Energía Eléctrica', 'key' => '5.2.2.5', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Agua Potable', 'key' => '5.2.2.6', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Arrendamiento', 'key' => '5.2.2.7', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Telefonía e Internet', 'key' => '5.2.2.8', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Mantenimiento', 'key' => '5.2.2.9', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Correo y Mensajería', 'key' => '5.2.2.10', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Vigilancia', 'key' => '5.2.2.11', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Limpieza', 'key' => '5.2.2.12', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Publicidad', 'key' => '5.2.2.13', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Viáticos', 'key' => '5.2.2.14', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Servicios Jurídicos', 'key' => '5.2.2.15', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Servicios de Contabilidad y Auditoría', 'key' => '5.2.2.16', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Servicios de Capacitación', 'key' => '5.2.2.17', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Consultorías y estudios diversos', 'key' => '5.2.2.18', 'parent_key' => '5.2.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciaciones y Amortizaciones', 'key' => '5.2.3', 'parent_key' => '5.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Edificio', 'key' => '5.2.3.1', 'parent_key' => '5.2.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Equipo de Oficina', 'key' => '5.2.3.2', 'parent_key' => '5.2.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Depreciación Vehículo Transporte', 'key' => '5.2.3.3', 'parent_key' => '5.2.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Gastos Financieros', 'key' => '5.3', 'parent_key' => '5', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Intereses y Comisiones Bancarias', 'key' => '5.3.1', 'parent_key' => '5.3', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Intereses', 'key' => '5.3.1.1', 'parent_key' => '5.3.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Comisiones Bancarias', 'key' => '5.3.1.2', 'parent_key' => '5.3.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Producción', 'key' => '5.4', 'parent_key' => '5', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Materiales', 'key' => '5.4.1', 'parent_key' => '5.4', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Desperdicio anormal', 'key' => '5.4.1.1', 'parent_key' => '5.4.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Unidades defectuosas anormales', 'key' => '5.4.1.2', 'parent_key' => '5.4.1', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Mano de obra', 'key' => '5.4.2', 'parent_key' => '5.4', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ocio anormal', 'key' => '5.4.2.1', 'parent_key' => '5.4.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ineficiencia en tiempo extra', 'key' => '5.4.2.2', 'parent_key' => '5.4.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Negligencia en tiempo extra', 'key' => '5.4.2.3', 'parent_key' => '5.4.2', 'balance_type' => 'D', 'account_type_key' => 'G', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ingresos', 'key' => '6', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ingresos Operacionales', 'key' => '6.1', 'parent_key' => '6', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ventas al Contado', 'key' => '6.1.1', 'parent_key' => '6.1', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ventas al Contado', 'key' => '6.1.1.1', 'parent_key' => '6.1.1', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ventas al Crédito', 'key' => '6.1.2', 'parent_key' => '6.1', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ventas al Crédito', 'key' => '6.1.2.1', 'parent_key' => '6.1.2', 'balance_type' => 'A', 'account_type_key' => 'I', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ingresos No Operacionales', 'key' => '6.2', 'parent_key' => '6', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Ingresos No Operacionales', 'key' => '6.2.1', 'parent_key' => '6.2', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Otros Ingresos', 'key' => '6.2.1.1', 'parent_key' => '6.2.1', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Resultados positivos por venta de Activos No Corrientes', 'key' => '6.2.1.2', 'parent_key' => '6.2.1', 'balance_type' => 'A', 'account_type_key' => 'Y', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Cuentas Liquidadoras', 'key' => '7', 'parent_key' => '', 'balance_type' => 'A', 'account_type_key' => 'L', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Cuentas Liquidadoras', 'key' => '7.1', 'parent_key' => '7', 'balance_type' => 'A', 'account_type_key' => 'L', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Cuentas Liquidadoras de Resultado', 'key' => '7.1.1', 'parent_key' => '7.1', 'balance_type' => 'A', 'account_type_key' => 'L', 'is_group' => 1, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Cuenta Liquidadora de Resultados', 'key' => '7.1.1.1', 'parent_key' => '7.1.1', 'balance_type' => 'A', 'account_type_key' => 'L', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Subaplicación de Costos Indirectos de Fabricación', 'key' => '7.1.1.2', 'parent_key' => '7.1.1', 'balance_type' => 'A', 'account_type_key' => 'L', 'is_group' => 0, 'account_chart_type_id' => 4));
		Account::create(array('name' => 'Sobreaplicación de Costos Indirectos de Fabricación', 'key' => '7.1.1.3', 'parent_key' => '7.1.1', 'balance_type' => 'A', 'account_type_key' => 'L', 'is_group' => 0, 'account_chart_type_id' => 4));


	}

}

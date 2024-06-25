<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm')->middleware('guest');
Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/producto','ProductoController');

Route::resource('mantenimiento/nivel','NivelController');
Route::resource('mantenimiento/tipo_habitacion','TipoHabitacionController');
Route::resource('mantenimiento/habitacion','HabitacionController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso_producto','IngresoController');
Route::resource('almacen/TipoCliente','TipoClienteController');
Route::resource('reserva/clientes','ClienteController');
Route::resource('d/d','Cliente2Controller');//ruta alterna
Route::get('reserva/registro/{id}/create', 'ReservaController@CrearReserva');
Route::get('reserva/registro/{id}/alquiler_reserva_create', 'ReservaController@alquiler_reserva_create')->name('alq_reserva');

Route::get('reserva/registro/{id}/renovar', 'ReservaController@renovarAlquiler')->name('renovarAlquiler');
Route::resource('reserva/registro','ReservaController');
// Controlador Extra
Route::resource('salidas/verificacion','SalidaController');
Route::resource('ventas/consumo','ConsumoController');
Route::resource('ventas/servicio','ServicioController');
Route::resource('ventas/otros','VentaController');
// para el reporte de los Listados de la Reserva
Route::get('reserva/listar-registro/{id}/report', 'LReservaController@report');
Route::get('reserva/listar-registro/{id}/{id2}/{id3}/{id4}/listado', 'LReservaController@listado')->name('listado.pdf');;
Route::resource('reserva/listar-registro','LReservaController');
Route::resource('reserva/listar-renovacion','LRenovacionController');
Route::resource('ventas/listar-consumo','LConsumoController');
Route::resource('reporte/caja','ReporteCajaController');
Route::resource('reporte/ingresos','ReporteController');
Route::resource('reporte/mensual','ReporteMensualController');
Route::resource('reporte/rango','ReporteRangoController');
Route::resource('reporte/rango_venta','ReporteRangoVentaController');
Route::resource('reporte/limpieza','ReporteLimpiezaController');
Route::resource('acceso/usuario','UsuarioController');
Route::resource('acceso/personal','PersonalController');
Route::resource('configuracion/datos_hotel','DatosController');
Route::resource('almacen/registrar_servicio','Servicio2Controller');
Route::resource('configuracion/tipo_documento','TipoDocController');
Route::resource('configuracion/unidad_medida','UMedidaController');
Route::resource('reserva/dashboard','DashboardController');
Route::resource('caja/apertura','AperturaCierreController');
Route::resource('caja/pago','Pago2Controller');
Route::resource('caja/ingreso','IngresoCajaController');
Route::resource('caja/egreso','EgresoController');
Route::resource('apartar','ApartarController');
Route::resource('respaldo/r_alquiler','RespAlquilerController');




//Reportes en Excel
Route::get('ingreso_diario/{id}/{id2}/{id3}', 'ReporteController@exportExcel')->name('ingreso_diario.excel');
Route::get('ingreso_mensual/{id}/{id2}', 'ReporteMensualController@exportExcel')->name('ingreso_mensual.excel');
Route::get('reportRango/{id}/{id2}/{id3}', 'ReporteRangoController@exportExcel')->name('reportRango.excel');

//Reporte en PDf - Comprobante del Hospedaje
Route::get('comprobante/{id}', 'ReservaController@exportPdf')->name('comprobante.pdf');
Route::get('arqueo_caja/{id}', 'AperturaCierreController@reportPdf')->name('arqueo_caja.pdf');
Route::get('arqueo_caja2/{id}', 'AperturaCierreController@reportPdf2')->name('arqueo_caja2.pdf');
Route::get('producto_pdf/{id}', 'ProductoController@producto_pdf')->name('producto_pdf.pdf');


Route::get('one_sale/{id}', 'VentaController@exportPdf')->name('one_sale.pdf');
Route::get('list_venta/{id}', 'VentaController@listPdf')->name('list_venta.pdf');
Route::get('list_compra/{id}/{id2}', 'IngresoController@list_compra')->name('list_compra.pdf');
Route::get('list_compraE/{id}/{id2}', 'IngresoController@list_compraE')->name('list_compra.excel');
Route::get('list_compraDetalladoE/{id}/{id2}', 'IngresoController@list_compraDetalladoE')->name('list_compraDetalladoE.excel');
Route::get('list_limpieza/{id}/{id2}/{id3}', 'ReporteLimpiezaController@list_limpieza')->name('list_limpieza.pdf');

// Ruta de configuración extras
Route::post('confHab/{id}', 'HabitacionController@confHab')->name('confHab');
Route::post('hablHab/{id}', 'HabitacionController@hablHab')->name('hablHab');
Route::post('enviar_limpieza', 'HabitacionController@enviar_limpieza')->name('enviar_limpieza');
Route::get('pagar_consumo/{id}/{id2}', "Pago2Controller@pagar_consumo")->name('pagar_consumo');


// AñadirServicio
Route::get('reserva/registro/{id}/agregar_servicio', 'ReservaController@add_service')->name('add_service');
Route::post('add_service_post', 'ReservaController@add_service_post')->name('add_service_post');

// Renovación
Route::post('renovar_post', 'ReservaController@renovar_post')->name('renovar_post');

// Ajax
Route::get('listar','ApartarController@listar');
Route::post('/apartar/guardar/','ApartarController@guardar');
Route::post('/apartar/editar/','ApartarController@editar');
Route::post('/apartar/eliminar/','ApartarController@eliminar');
Route::post('/apartar/alquilar/','ApartarController@alquilar');
// Fetch

Route::get('obtenerClientes', 'ClienteController@obtenerClientes')->name('obtenerClientes');
Route::post('guardarCliente', 'ClienteController@guardarCliente')->name('guardarCliente');

Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



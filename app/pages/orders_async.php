<?php

require_once '../lib/core.lib.php';

if ($GPC['type'] == 'list-orders') {

//    $orders = Orders::getInstance()->getTime($GPC);
    $orders = Orders::getInstance()->getOrders([""]);
    ?>
    <!--    <form class="mb-3" class="filter-form" action="orders_async.php" data-target=".filter-results">-->
    <form class="mb-3 filter-form" class="filter-form" action="orders_async.php">
        <input type="hidden" name="type" value="filter-orders">

        <div class="row mb-3">
            <div class="col-6">
                <div class="form-group">
                    <label>Origen</label>
                    <input type="text" class="form-control" name="origen" placeholder="Buscar">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Destino</label>
                    <input type="text" class="form-control" name="destino" placeholder="Buscar">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Salida</label>
                    <input type="date" class="form-control" name="salida" placeholder="Buscar">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Retorno</label>
                    <input type="date" class="form-control" name="retorno" placeholder="Buscar">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Total</label>
                    <input type="text" class="form-control" name="total" placeholder="Buscar">
                </div>
            </div>
        </div>
        <div class="row mb-3 justify-content-between">
            <div class="col-2">
                <button type="button" class="btn btn-success btn-submit">Buscar</button>
                <button type="clear" class="btn btn-secondary btn-clear">Limpiar</button>
            </div>

            <div class="col-2 d-flex justify-content-end">
                <button type="button"
                        class="btn btn-primary btn-load-async"
                        data-action="orders_async.php"
                        data-type="record-orders"
                        data-target="main">
                    Agregar
                </button>
            </div>
        </div>
    </form>

    <div class="filter-results">
        <?php pintarTabla($orders); ?>
    </div>
<?php }

if ($GPC['type'] == 'filter-orders') {
    $arrOrders = Orders::getInstance()->getOrders($GPC);
//    $arrOrdersDemo = Orders::getInstance()->getOrdersAll($GPC);
    pintarTabla($arrOrders);
    ?>
<?php }

if ($GPC['type'] == 'record-orders') {
    $order = [];
    $exists = !empty($GPC['id']);
    if ($exists) {
        $order = Orders::getInstance()->exec("SELECT * FROM orders WHERE id = {$GPC['id']}")[0];
    }
    ?>

    <div class="container">
        <form action="orders_async.php">
            <div class="row">
                <div class="col-12">
                    <h1><?php echo !$exists ? 'Crear' : 'Actualizar'; ?> orden</h1>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <form action="orders_async.php">
                        <input type="hidden" name="type" value="save-order">
                        <input type="hidden" name="id" value="<?= $order['id'] ?>">

                        <div class="form-group">
                            <label>Origen</label>
                            <input type="text" class="form-control" name="origen" value="<?= $order['origen'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Destino</label>
                            <input type="text" class="form-control" name="destino" value="<?= $order['destino'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Salida</label>
                            <input type="date" class="form-control" name="salida" value="<?= $order['salida'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Retorno</label>
                            <input type="date" class="form-control" name="retorno" value="<?= $order['retorno'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Total</label>
                            <input type="text" class="form-control" name="total" value="<?= $order['total'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Estatus</label>
                            <select name="estatus" class="form-select">
                                <option value="" selected>Escoja una opción</option>
                                <option value="1">Activo</option>
                                <option value="2">En proceso</option>
                                <option value="3">Finalizado</option>
                                <option value="4">Cancelado</option>
                                <option value="5">Anulado</option>
                                <option value="6">Prueba</option>
                            </select>
                            <input type="text" class="form-control" name="total" placeholder="Buscar">
                        </div>

                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?= $order['fecha'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Hora</label>
                            <input type="time" class="form-control" name="hora" value="<?= $order['hora'] ?>">
                        </div>
                        <!--                        fila dentro del formulario-->
                        <div class="row mb-3">
                            <div class="col-3">
                                <button type="button"
                                        class="btn btn-success btn-form-async"
                                        data-action="list-orders"
                                        data-target="main">
                                    Guardar
                                </button>
                                <button type="button"
                                        class="btn btn-dark btn-load-async"
                                        data-action="orders_async.php"
                                        data-type="list-orders"
                                        data-target="main">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </form>
    </div>
<?php }

if ($GPC['type'] == 'save-order') {
    if (empty($GPC['id'])) {
        $query = "INSERT INTO orders (origen, destino, salida, retorno, total, estatus, fecha, hora) VALUES ('{$GPC['origen']}', '{$GPC['destino']}', '{$GPC['salida']}', '{$GPC['retorno']}', '{$GPC['total']}', '{$GPC['estatus']}', '{$GPC['fecha']}', '{$GPC['hora']}')";
    } else {
        $query = "UPDATE orders SET origen = '{$GPC['origen']}', destino = '{$GPC['destino']}', salida = '{$GPC['salida']}', retorno = '{$GPC['retorno']}', total = '{$GPC['total']}', fecha = '{$GPC['fecha']}', hora = '{$GPC['hora']}', estatus = '{$GPC['estatus']}' WHERE id = {$GPC['id']}";
    }

    Orders::getInstance()->exec($query);

    die(json_encode(['status' => 'OK']));
}

function pintarTabla($orders)
{
    ?>
    <table class="table table-striped table-border" id="tbOrdenes">
        <thead>
        <tr>
            <th>N°</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Salida</th>
            <th>Retorno</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
        </thead>

        <tbody>
        <?php if (empty($orders)) : ?>
            <tr>
                <td class="text-center" colspan="9">No hay registros</td>
            </tr>
        <?php else : ?>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['origen'] ?></td>
                    <td><?= $order['destino'] ?></td>
                    <td><?= $order['salida'] ?></td>
                    <td><?= $order['retorno'] ?></td>
                    <td><?= $order['total'] ?></td>
                    <td><?= $order['fecha'] ?></td>
                    <td><?= $order['hora'] ?></td>
                    <td><?= getNombreEstatus($order['estatus']) ?></td>
                    <td>
                        <button type="button"
                                class="btn btn-primary btn-load-async"
                                data-action="orders_async.php"
                                data-type="record-orders"
                                data-params="<?php echo toObject(['id' => $order['id']]); ?>"
                                data-target="main">
                            Editar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
}

function getNombreEstatus($estatus)
{
    switch ($estatus) {
        case 1:
            $nombreEstatus = "Activo";
            break;
        case 2:
            $nombreEstatus = "En proceso";
            break;
        case 3:
            $nombreEstatus = "Finalizado";
            break;
        case 4:
            $nombreEstatus = "Cancelado";
            break;
        case 5:
            $nombreEstatus = "Anulado";
            break;
        case 6:
            $nombreEstatus = "Prueba";
            break;
        default:
            $nombreEstatus = "--";
    }
    return $nombreEstatus;
}


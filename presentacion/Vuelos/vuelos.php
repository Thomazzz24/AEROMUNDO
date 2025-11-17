<?php
$vuelo = new Vuelo();
$vuelos = $vuelo->consultarTodos();
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Vuelos Programados</h2>

    <table class="table table-striped table-hover shadow-sm">
        <thead class="table-danger">
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Avión</th>
                <th>Salida</th>
                <th>Llegada</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($vuelos as $v) { ?>
                <tr>
                    <td><?php echo $v[0]; ?></td>
                    <td><?php echo $v[1]; ?></td>
                    <td><?php echo $v[2]; ?></td>
                    <td><?php echo $v[3]; ?></td>
                    <td><?php echo $v[4]; ?></td>
                    <td><?php echo $v[5]; ?></td>
                    <td><?php echo ($v[6] == 1) ? "Activo" : "Inactivo"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

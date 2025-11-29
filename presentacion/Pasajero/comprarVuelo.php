<?php
$vuelo = new Vuelo();
$vuelos = $vuelo->consultarTodos();

include "menuPasajero.php"; 

?>




<div class="container mt-4">
    <h2 class="text-center mb-4">Vuelos Disponibles</h2>

    <table class="table table-striped table-hover shadow-sm">
        <thead class="table-danger">
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Avión</th>
                <th>Piloto</th>
                <th>Copiloto</th>
                <th>Salida</th>
                <th>Llegada</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($vuelos as $v) { ?>
                <tr>
                    <td><?php echo $v->getId_vuelo(); ?></td>
                    <td><?php echo $v->getOrigen(); ?></td>
                    <td><?php echo $v->getDestino(); ?></td>
                    <td><?php echo $v->getModelo(); ?></td>
                    <td><?php echo $v->getPiloto_principal(); ?></td>
                    <td><?php echo $v->getCopiloto(); ?></td>
                    <td><?php echo date('d/m/y H:i', strtotime($v->getFecha_salida())); ?></td>
                    <td><?php echo date('d/m/y H:i', strtotime($v->getFecha_llegada())); ?></td>
                    <td>
                        <?php echo ($v->getEstado() == 1) 
                            ? "<span class='badge bg-success'>Activo</span>" 
                            : "<span class='badge bg-warning'>Inactivo</span>"; 
                        ?>
                    </td>

                    <!-- BOTÓN PARA COMPRAR -->
                    <td>
                        <?php if ($v->getEstado() == 1) { ?>
                            <a href="?pid=<?php echo base64_encode('presentacion/Pasajero/comprarTiquete.php'); ?>&idVuelo=<?php echo $v->getId_vuelo(); ?>"
                               class="btn btn-primary btn-sm">
                               Comprar
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

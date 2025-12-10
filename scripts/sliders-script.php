<?php
$consulta = $conexion->query("
    SELECT id_publicacion, titulo, imagen, tema
    FROM publicacion
    ORDER BY id_publicacion DESC
    LIMIT 10
");
?>

<div class="slider-container">
    <div class="slider-track">
        <?php while ($row = $consulta->fetch_assoc()) : ?>
            <div class="slide">
                <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="Noticia" onerror="this.src='src/no-image.png'">
                <div class="slide-info">
                    <span class="tema"><?= htmlspecialchars($row['tema']) ?></span>
                    <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                    <a href="noticia.php?id=<?= $row['id_publicacion'] ?>" class="btn-ver">Ver más</a>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- duplicado para loop infinito -->
        <?php
        $consulta->data_seek(0); // volver al inicio del resultado
        while ($row = $consulta->fetch_assoc()) : ?>
            <div class="slide">
                <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="Noticia" onerror="this.src='src/no-image.png'">
                <div class="slide-info">
                    <span class="tema"><?= htmlspecialchars($row['tema']) ?></span>
                    <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                    <a href="noticia.php?id=<?= $row['id_publicacion'] ?>" class="btn-ver">Ver más</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>



</div>
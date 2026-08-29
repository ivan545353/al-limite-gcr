<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
{
    DB::statement("
        CREATE OR REPLACE VIEW vw_publicacion_publica AS
        SELECT
            p.id_publicacion,
            p.titulo,
            p.slug,
            p.bajada,
            p.destacada,
            p.fecha_publicacion,
            p.visitas,
            t.nombre  AS tipo,
            t.slug    AS tipo_slug,
            c.nombre  AS categoria,
            c.slug    AS categoria_slug,
            CONCAT(u.nombre, ' ', u.apellido) AS autor,
            u.rol_publico,
            u.foto    AS autor_foto,
            m.ruta_original AS portada,
            m.alt     AS portada_alt,
            p.cantidad_votos,
            CASE WHEN p.cantidad_votos >= 5 THEN p.promedio ELSE NULL END AS promedio_publico,
            TIMESTAMPDIFF(HOUR, p.fecha_publicacion, UTC_TIMESTAMP()) < 12 AS editable
        FROM publicacion p
        JOIN tipo_publicacion t ON t.id_tipo = p.id_tipo
        JOIN categoria c        ON c.id_categoria = p.id_categoria
        JOIN usuario u          ON u.id_usuario = p.id_autor
        LEFT JOIN media m       ON m.id_media = p.id_media_portada
        WHERE p.estado = 'PUBLICADA'
    ");
}

public function down(): void
{
    DB::statement('DROP VIEW IF EXISTS vw_publicacion_publica');
}
};

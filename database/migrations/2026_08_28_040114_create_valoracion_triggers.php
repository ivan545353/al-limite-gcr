<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
{
    DB::unprepared("
        CREATE TRIGGER trg_valoracion_insert
        AFTER INSERT ON valoracion
        FOR EACH ROW
        BEGIN
            IF NEW.sospechosa = FALSE THEN
                UPDATE publicacion
                   SET suma_puntos    = suma_puntos + NEW.valor,
                       cantidad_votos = cantidad_votos + 1
                 WHERE id_publicacion = NEW.id_publicacion;
            END IF;
        END
    ");

    DB::unprepared("
        CREATE TRIGGER trg_valoracion_update
        AFTER UPDATE ON valoracion
        FOR EACH ROW
        BEGIN
            DECLARE v_delta_puntos INT DEFAULT 0;
            DECLARE v_delta_votos  INT DEFAULT 0;

            IF OLD.sospechosa = FALSE THEN
                SET v_delta_puntos = v_delta_puntos - CAST(OLD.valor AS SIGNED);
                SET v_delta_votos  = v_delta_votos - 1;
            END IF;

            IF NEW.sospechosa = FALSE THEN
                SET v_delta_puntos = v_delta_puntos + CAST(NEW.valor AS SIGNED);
                SET v_delta_votos  = v_delta_votos + 1;
            END IF;

            IF v_delta_puntos <> 0 OR v_delta_votos <> 0 THEN
                UPDATE publicacion
                   SET suma_puntos    = suma_puntos + v_delta_puntos,
                       cantidad_votos = cantidad_votos + v_delta_votos
                 WHERE id_publicacion = NEW.id_publicacion;
            END IF;
        END
    ");

    DB::unprepared("
        CREATE TRIGGER trg_valoracion_delete
        AFTER DELETE ON valoracion
        FOR EACH ROW
        BEGIN
            IF OLD.sospechosa = FALSE THEN
                UPDATE publicacion
                   SET suma_puntos    = suma_puntos - CAST(OLD.valor AS SIGNED),
                       cantidad_votos = cantidad_votos - 1
                 WHERE id_publicacion = OLD.id_publicacion;
            END IF;
        END
    ");
}

public function down(): void
{
    DB::unprepared('DROP TRIGGER IF EXISTS trg_valoracion_insert');
    DB::unprepared('DROP TRIGGER IF EXISTS trg_valoracion_update');
    DB::unprepared('DROP TRIGGER IF EXISTS trg_valoracion_delete');
}
};

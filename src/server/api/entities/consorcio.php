<?php
require_once './../../utils/autoload.php';
class Consorcio
{

    private $connection;
    private $validator;
    private $query;
    private $tabla = "consorcio";
    /* Campos de la tabla */
    private $idConsorcio;
    private $nombre;
    private $cuit;
    private $calle;
    private $altura;
    private $telefono;
    private $superficie;
    private $barrio;
    private $coordenadaLatitud;
    private $coordenadaLongitud;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try { $this->validator = new Validator;} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    public function crearConsorcio($nombre, $cuit, $calle, $altura, $superficie, $barrio, $telefono = null, $coordenadaLatitud = 0, $coordenadaLongitud = 0)
    {
        $this->setNombre($nombre);
        $this->setCuit($cuit);
        $this->setCalle($calle);
        $this->setAltura($altura);
        $this->setTelefono($telefono);
        $this->setSuperficie($superficie);
        $this->setBarrio($barrio);
        $this->setCoordenadaLatitud($coordenadaLatitud);
        $this->setCoordenadaLongitud($coordenadaLongitud);

        return $this->insertConsorcio();
    }
    public function listarConsorciosArrayFormateado()
    {
        $result = array();
        $query = "select id_consorcio, nombre from" . $this->tabla . " order by nombre";
        while ($reg = mysql_fetch_assoc($this->connection->ejecutar($query))) {
            $result[$reg['id_consorcio']] = $reg['nombre'];
        }
        return $result;
    }
    public function listarConsorciosCompleto()
    {
        $query = "select * from " . $this->tabla;
        return $this->connection->ejecutar($query);
    }

    public function listarConsorciosConReclamos()
    {
        $query = "
            SELECT DISTINCT
                C.id_consorcio AS id_consorcio,
                C.nombre as nombre
            FROM
                reclamo AS R
            INNER JOIN unidad AS U
            ON
                R.id_unidad = U.id_unidad
            INNER JOIN consorcio AS C
            ON
                C.id_consorcio = U.id_consorcio
        ";
        return $this->connection->ejecutar($query);
    }

    public function listarConsorciosConGastos()
    {
        $query = "
            SELECT DISTINCT
                C.id_consorcio AS id_consorcio,
                C.nombre AS nombre
            FROM
                gasto AS G
            INNER JOIN reclamo AS R
            ON
                R.id_reclamo = G.id_reclamo
            INNER JOIN unidad AS U
            ON
                R.id_unidad = U.id_unidad
            INNER JOIN consorcio AS C
            ON
                C.id_consorcio = U.id_consorcio
        ";
        return $this->connection->ejecutar($query);
    }

    public function traerConsorcioByID($id)
    {
        $query = "select * from " . $this->tabla . "WHERE id_consorcio = " . $id;
        return mysql_fetch_assoc($this->connection->ejecutar($query));
    }
    public function traerParticipacionDelConsorcio($consorcio)
    {
        return $this->obtenerParticipacionDelConsorcio($consorcio);
    }
    private function obtenerParticipacionDelConsorcio($consorcio)
    {
        $this->query = "SELECT u.id_unidad idUnidad, u.prc_participacion participacion FROM " . $this->tabla . " c"
            . " INNER JOIN unidad u ON c.id_consorcio = u.id_consorcio"
            . " WHERE c.id_consorcio = ?";
        $arrType = array("i");
        $arrParam = array($consorcio);
        $arrUnidades = $this->executeQuery($arrType, $arrParam);

        while ($unidad = $arrUnidades->fetch_assoc()) {
            $unidadesEncontradas[$unidad['idUnidad']] = $unidad['participacion'];
        }
        return $unidadesEncontradas;
    }
    private function insertConsorcio()
    {
        $query = "INSERT INTO $this->tabla
        (nombre, cuit, calle, altura, telefono, superficie, id_barrio, coordenadaLatitud, coordenadaLongitud)
        VALUES (('$this->nombre'),
        ('$this->cuit'),
        ('$this->calle'),
        ($this->altura),
        ('$this->telefono'),
        ($this->superficie),
        ($this->barrio),
        ($this->coordenadaLatitud),
        ($this->coordenadaLongitud))
        ";
        return $this->connection->ejecutar($query);
    }

    private function setNombre($nombre)
    {
        try { $this->nombre = $this->validarVariableString($nombre);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuit($cuit)
    {
        try { $this->cuit = $this->validarVariableString($cuit);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCalle($calle)
    {
        try { $this->calle = $this->validarVariableString($calle);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setAltura($altura)
    {
        try { $this->altura = $this->validarVariableNumerica($altura);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setTelefono($telefono)
    {
        /* try{$this->telefono = $this->validarVariableString($telefono);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); } */
        $this->telefono = $telefono;
    }
    private function setSuperficie($superficie)
    {
        try { $this->superficie = $this->validarVariableNumerica($superficie);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setBarrio($barrio)
    {
        try { $this->barrio = $this->validarVariableNumerica($barrio);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    public function setCoordenadaLatitud($coordenadaLatitud)
    {
        try {
            $this->coordenadaLatitud = $this->validarVariableNumerica($coordenadaLatitud);
        } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    public function setCoordenadaLongitud($coordenadaLongitud)
    {
        try {
            $this->coordenadaLongitud = $this->validarVariableNumerica($coordenadaLongitud);
        } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    private function validarVariableString($var)
    {
        if (!empty($var) && is_string($var)) {
            return $this->elimina_acentos($var);
        } else {
            throw new Exception("El valor es null o no es de tipo String");
        }
    }
    private function validarVariableNumerica($var)
    {
        if (!empty($var) && is_numeric($var)) {
            return $var;
        } else {
            throw new Exception("El valor es null o no es de tipo Numerico");
        }
    }
    // Ejemplo: Si en mi query necesito pasarle el valor 14, "Calle Falsa", "432"
    // $arrType = array("i","s","s") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function executeQuery($arrType = null, $arrParam = null)
    {
        try { $q = new Query($this->connection);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}

        return $q->execute(array($this->query), $arrType, $arrParam);
    }

    private function elimina_acentos($text)
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array(
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',

            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',

            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',

            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',

            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',

            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',

            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
        );

        $text = preg_replace(array_keys($patron), array_values($patron), $text);
        return $text;
    }
}

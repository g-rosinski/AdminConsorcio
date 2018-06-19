<?php

require_once './../../utils/autoload.php';

class Unidad 
{
    private $connection;
    private $tabla = "unidad";
    /* Campos de la tabla */
    private $idUnidad;
    private $prcParticipacion; //setPrcParticipacion
    private $piso; //setPiso
    private $departamento; //setDepartamento
    private $nro_unidad; //setNro_unidad
    private $superficie; //setSuperficie
    private $id_consorcio; //setIdConsorcio
    private $validator;
    
    private $query;
    
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }

    // executeQuery ejecuta la consulta, utiliza la query del atributo, recibe como parametro 2 arrays que se utilizarán para bindear a la query
    // $arrType = array [ 0 => "<string>"] El string que debe ir es la letra del tipo de dato que se pasará por parametro
    // Letras según tipo de dato i = int ; s = string ; d = double
    // $arrParam = array [ 0 => "<string>", 1 => "<string>", n => "<string>"] El string será valor que bindeara a la query
    // Ejemplo: Si en mi query necesito pasarle el valor 14, "Calle Falsa", "432"
    // $arrType = array("iss") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function execute($arrType = null, $arrParam = null)
    {   
        try{ $q = new Query($this->connection); }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
        
        return $q->execute(array($this->query),$arrType,$arrParam);
    }
    
    public function unidadesConPropietarioAsignado($consorcio){
        $this->setIdConsorcio($consorcio);
        return $this->consultarUnidadesConPropietario();
    }
    public function unidadesSinPropietarioAsignado($consorcio){
        $this->setIdConsorcio($consorcio);
        return $this->consultarUnidadesSinPropietario();
    }

    // ESTA FUNCION TIENE QUE IR ACA?
    public function agregarRelacionPersonaUnidad($user, $rol, $id_unidad)
    {
        if ($rol == 'PROPIETARIO') {
            return $this->relacionPersonaUnidad($user, null, $id_unidad);
        } else {
            $resultado = $this->obtenerPropietarioUnidad($id_unidad)->fetch_assoc();
            return $this->relacionPersonaUnidad($user, $resultado['user'], $id_unidad);
        }
    }
    
    private function relacionPersonaUnidad($user, $inquilino_de, $id_unidad)
    {
        $inquilino_de = $inquilino_de ? "'" . $inquilino_de . "'" : 'null';
        $query = "INSERT INTO propietariounidad (`user`, `inquilino_de`, `id_unidad`)
                    VALUES (('$user'), ($inquilino_de), ($id_unidad))";
        return $this->connection->ejecutar($query);
    }
    
    
    private function consultarUnidadesSinPropietario()
    {
        $this->query =    "SELECT u.id_unidad, u.piso AS piso , u.departamento AS deptoUnidad
                            FROM unidad u left join propietariounidad p on p.id_unidad = u.id_unidad
                            WHERE u.id_consorcio = ?
                            AND p.user is null";
        $arrType = array ("i");
        // echo $this->id_consorcio;die;
        $arrParam = array(
            $this->id_consorcio
        );
        return $this->execute($arrType,$arrParam);
    }
    private function consultarUnidadesConPropietario()
    {    
        $this->query =    "SELECT u.id_unidad, u.piso AS piso , u.departamento AS deptoUnidad
                            FROM unidad u left join propietariounidad p on p.id_unidad = u.id_unidad
                            WHERE u.id_consorcio = ?
                            AND p.user IS NOT NULL
                            AND p.inquilino_de IS NULL
                            AND p.id_unidad NOT IN (SELECT p2.id_unidad
                                                    FROM propietariounidad p2
                                                    WHERE p2.id_unidad = p.id_unidad
                                                    AND p2.inquilino_de IS NOT NULL)
                            ";
        $arrType = array ("i");
        $arrParam = array(
            $this->id_consorcio
        );
        return $this->execute($arrType,$arrParam);
    }
    private function consultarUnidadesOcupadasPorConsorcio(){
        $this->query =     "SELECT p.id_unidad 
                            FROM propietariounidad p
                            INNER JOIN unidad u on p.id_unidad = u.id_unidad 
                            WHERE  p.inquilino_de IS NOT NULL
                            AND u.id_consorcio = ?";
        $arrType = array ("i");
        $arrParam = array(
            $this->id_consorcio
        );
        return $this->execute($arrType,$arrParam);
    }

    private function obtenerPropietarioUnidad($unidad)
    {
        $this->query = "SELECT user FROM propietariounidad WHERE id_unidad = ?";
        $arrType = array ("i");
        $arrParam = array(
            $unidad
        );
        return $this->execute($arrType,$arrParam );
    }

    private function setIdConsorcio($id_consorcio)
    {
        try { $this->id_consorcio = $this->validator->validarVariableNumerica($id_consorcio);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setPrcParticipacion($prcParticipacion)
    {
        try { $this->prcParticipacion = $this->validator->validarVariableNumerica($prcParticipacion);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setPiso($piso)
    {
        try { $this->piso = $this->validator->validarVariableNumerica($piso);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setDepartamento($departamento)
    {
        try { $this->departamento = $this->validator->validarVariableString($departamento);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setNro_unidad($nro_unidad)
    {
        try { $this->nro_unidad = $this->validator->validarVariableNumerica($nro_unidad);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setSuperficie($superficie)
    {
        try { $this->superficie = $this->validator->validarVariableNumerica($superficie);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    // private function validarVariableString($var)
    // {
    //     if (!empty($var) && is_string($var)) {
    //         return $var;
    //     } else {
    //         throw new Exception("El valor es null o no es de tipo String");
    //     }
    // }
    // private function validarVariableNumerica($var)
    // {
    //     if (!empty($var) && is_numeric($var)) {
    //         return $var;
    //     } else {
    //         throw new Exception("El valor es null o no es de tipo Numerico");
    //     }
    // }
}

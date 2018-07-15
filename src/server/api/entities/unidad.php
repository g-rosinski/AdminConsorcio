<?php

require_once './../../utils/autoload.php';

class Unidad 
{
    private $connection;
    private $validator;
    private $query;
    private $tabla = "unidad";
    /* Campos de la tabla */
    private $idUnidad;
    private $prcParticipacion; //setPrcParticipacion
    private $piso; // $this->setPiso
    private $departamento; // $this->setDepartamento
    private $nro_unidad; // $this->setNro_unidad
    private $superficie; // $this->setSuperficie
    private $id_consorcio; // $this->setIdConsorcio
    
    
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }
    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function unidadesConPropietarioAsignado($consorcio){
        $this->setIdConsorcio($consorcio);
        return $this->consultarUnidadesConPropietario();
    }
    public function unidadesSinPropietarioAsignado($consorcio){
        $this->setIdConsorcio($consorcio);
        return $this->consultarUnidadesSinPropietario();
    }
    public function agregarRelacionPersonaUnidad($user, $rol, $id_unidad)
    {
        if ($rol == 'PROPIETARIO') {
            return $this->vincularPropietarioAUnidad($user,$id_unidad);
        } else {
            $propietario = $this->obtenerPropietarioUnidad($id_unidad)->fetch_assoc();
            return $this->vincularInquilinoAUnidad($user, $propietario['user'], $id_unidad);
        }
    }
    public function vincularPropietarioAUnidad($user, $unidad){
        $this->query = "INSERT INTO propietariounidad (user,id_unidad)
                        VALUES (?,?)";
        $arrType = array("s","i");
        $arrParam = array(
            $user,
            $unidad
        );
        return $this->executeQuery($arrType,$arrParam);  
    } 
    public function calcularPrcParticipacionPorConsorcios($consorcios = array())
    {   
        foreach ($consorcios as $id_consorcio) {
            $this->setIdConsorcio($id_consorcio);
            $arrUnidadesConSuperficie = $this->obtenerEspacioOcupadoPorUnidad();
            $totalSuperficie = $this->obtenerEspacioTotalPorConsorcio();
            foreach ($arrUnidadesConSuperficie as $id_unidad => $superficieUnidad) {
                $prcParticipacion = round($superficieUnidad/($totalSuperficie/100),3);
                $this->setIdUnidad($id_unidad);
                $this->setPrcParticipacion($prcParticipacion);
                $this->actualizarPrcParticipacion();
            }
        }
    }
    public function traerUnidadesPorConsorcio($id_consorcio)
    {
        $this->setIdConsorcio($id_consorcio);
        return $this->consultarUnidadesPorConsorcio();
    }
    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function consultarUnidadesPorConsorcio()
    {
        $this->query = "SELECT id_unidad as id FROM ".$this->tabla
                        ." WHERE id_consorcio = ?";
        $arrType = array("i");
        $arrParam= array($this->id_consorcio);
        $resultado = $this->executeQuery($arrType,$arrParam);
        $arrUnidadConSuperficie=array();
        while ($reg = $resultado->fetch_assoc()) {
            $arrUnidadConSuperficie[] = $reg['id'];
        }
        if(!empty($arrUnidadConSuperficie)){
            return $arrUnidadConSuperficie;         
        }else{
            return false;
        }
    }
    private function obtenerEspacioOcupadoPorUnidad()
    {
        $this->query = "SELECT id_unidad as id, superficie FROM ".$this->tabla
                        ." WHERE id_consorcio = ?";
        $arrType = array("i");
        $arrParam= array($this->id_consorcio);
        $resultado = $this->executeQuery($arrType,$arrParam);
        while ($reg = $resultado->fetch_assoc()) {
            $arrUnidadConSuperficie[$reg['id']] = $reg['superficie'];
        }        
        return $arrUnidadConSuperficie;
    } 
    private function obtenerEspacioTotalPorConsorcio()
    {
        $this->query = "SELECT superficie FROM consorcio"
                        ." WHERE id_consorcio = ?";
        $arrType = array("i");
        $arrParam= array($this->id_consorcio);
        $consorcio = $this->executeQuery($arrType,$arrParam)->fetch_assoc();;
        return $consorcio['superficie'];
    } 
    private function actualizarPrcParticipacion(){
        $this->query = "UPDATE ".$this->tabla ." SET prc_participacion = ?"
                       ." WHERE id_unidad = ?";
        $arrType = array("d","i");
        $arrParam = array(
            $this->prcParticipacion,
            $this->idUnidad
        );
        return $this->executeQuery($arrType,$arrParam); 
    }
    private function vincularInquilinoAUnidad($user, $propietario, $unidad){
        $this->query = "INSERT INTO propietariounidad (user, inquilino_de,id_unidad)
                        VALUES (?,?,?)";
        $arrType = array("s","s","i");
        $arrParam = array(
            $user,
            $propietario,
            $unidad
        );
        return $this->executeQuery($arrType,$arrParam); 
    }
    
    private function consultarUnidadesSinPropietario()
    {
        $this->query =    "SELECT u.id_unidad, u.piso AS piso , u.departamento AS deptoUnidad
                            FROM unidad u left join propietariounidad p on p.id_unidad = u.id_unidad
                            WHERE u.id_consorcio = ?
                            AND p.user is null";
        $arrType = array ("i");
        $arrParam = array(
            $this->id_consorcio
        );
        return $this->executeQuery($arrType,$arrParam);
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
        return $this->executeQuery($arrType,$arrParam);
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
        return $this->executeQuery($arrType,$arrParam);
    }

    private function obtenerPropietarioUnidad($unidad)
    {
        $this->query = "SELECT user FROM propietariounidad WHERE id_unidad = ?";
        $arrType = array ("i");
        $arrParam = array(
            $unidad
        );
        return $this->executeQuery($arrType,$arrParam );
    }

    private function setIdUnidad($idUnidad)
    {
        try { $this->idUnidad = $this->validator->validarVariableNumerica($idUnidad);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
    private function setIdConsorcio($id_consorcio)
    {
        try { $this->id_consorcio = $this->validator->validarVariableNumerica($id_consorcio);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    // executeQuery ejecuta la consulta, utiliza la query del atributo, recibe como parametro 2 arrays que se utilizarán para bindear a la query
    // $arrType = array [ 0 => "<string>"] El string que debe ir es la letra del tipo de dato que se pasará por parametro
    // Letras según tipo de dato i = int ; s = string ; d = double
    // $arrParam = array [ 0 => "<string>", 1 => "<string>", n => "<string>"] El string será valor que bindeara a la query
    // Ejemplo: Si en mi query necesito pasarle el valor 14, "Calle Falsa", "432"
    // $arrType = array("i","s","s") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function executeQuery($arrType = null, $arrParam = null)
    {   
        try{ $q = new Query($this->connection); }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
        
        return $q->execute(array($this->query),$arrType,$arrParam);
    }
}

<?php
/**
 * Purifica datos antes de ser guardados
 * @version 1.0
 * @author Diego Castro <diego.castro@knowbi.com>
 */
class Purifier extends CApplicationComponent {

    protected $parser = null;

    public function __construct() {
        $this->parser = new CHtmlPurifier();
    }
    /**
     * Purifica el texto como texto plano
     * @param mixed $data Datos a purificar
     * @return $mixed Datos purificados
     */
    public function purify($data){
      $this->parser->options=array(
        'HTML.Allowed'=>'',
      );
      return $this->_purify($data);
    }
    /**
     * Purifica los datos como html
     * @param mixed $data Datos a purificar
     * @return mixed Datos purificados
     */
    public function purifyHtml($data){
      $this->parser->options=array();
      return $this->_purify($data);
    }
    /**
     * Purifica unos datos
     * @param mixed $data Datos a purificar
     * @return mixed
     */
    private function _purify($data) {
        if (isset($data) and is_array($data)) {
            $data = $this->purifyArray($data);
        } elseif (isset($data) and !is_array($data)) {
            $data = $this->parser->purify(trim($data));
        }
        return $data;
    }
    /**
     * Purifica un array
     * @param array $request_data Datos a purificar
     * @return $array Datos purificados
     */
    private function purifyArray(array $request_data) {
        foreach ($request_data as $key => $value) {
            if (isset($value) and is_array($value)) {
                $request_data[$key] = $this->purifyArray($value);
            } elseif (isset($value)) {
                $request_data[$key] = $this->parser->purify(trim($value));
            }
        }
        return $request_data;
    }

}

?>

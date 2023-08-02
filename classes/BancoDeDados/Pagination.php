<?php
namespace Classes\BancoDeDados;

class Pagination {

    /**
     * numero máximo de registros por página
     * @var integer
     */
    private $limit;

    /**
     * quantidade total de resultados do banco
     * @var integer
     */
    private $results;

    /**
     * quantidade de páignas
     * @var integer
     */
    private $pages;

    /**
     * Página atual
     * @var integer
     */
    private $currentPage;

    /**
     * construtor da classe
     * @param integer $results
     * @param integer $currentPage
     * @param integer $limit
     */
    public function __construct($results,$currentPage=1,$limit=10){
        $this->results = $results;
        $this->limit = $limit;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
        $this->calculate();
    }

    /**
     * metodo responsável por calcular a paginação
     */
    private function calculate(){
        // calculando total de paginas
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        //verifica se a página não excede o numero de paginas
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;

    }

    /**
     * retornará a clausula limit
     * @return string
     */
    public function getLimit(){
        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset.','.$this->limit;
    }
    
    /**
     * metodo responsavel por retornar as opções de página disponiveis
     * @return array
     */
    public function getPages(){
        //não retorna páginas
        if($this->pages ==1) return [];

        //paginas
        $paginas = [];
        for($i = 1; $i <= $this->pages;$i++){
            $paginas[] = [
                'pagina' => $i,
                'atual' => $i == $this->currentPage
            ];
        }
        return $paginas;
    }
}
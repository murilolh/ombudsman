<?php

class Paginator {
    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
    private $_row_start;

    public function __construct( $conn, $query ) {
      $this->_conn = $conn;
      $this->_query = $query;

      $rs = $this->_conn->query( $this->_query );
      $this->_total = $rs->num_rows;
    }

    public function getData( $limit = 8, $page = 1 ) {
        $this->_limit = $limit;
        $this->_page = $page;

        $this->_row_start = ( ( $this->_page - 1 ) * $this->_limit );
        $query = $this->_query . " LIMIT {$this->_row_start}, $this->_limit";

        $rs = $this->_conn->query( $query ) or die($this->_conn->error);

        while ( $row = $rs->fetch_assoc() ) {
            $results[]  = $row;
        }

        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = !empty($results) ? $results : null;

        return $result;
    }

    public function createLinks( $links, $list_class ) {
        $last = ceil( $this->_total / $this->_limit );
        $start = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

        $html = '<ul class="' . $list_class . '">';

        $class = ( $this->_page == 1 ) ? "disabled" : "";

        $previous_page = ( $this->_page == 1 ) ?
        '<a href=""><li class="' . $class . '">&laquo;</a></li>' :
        '<li class="' . $class . '"><a href="#" onclick="changePage(' . ( $this->_page - 1 ) . ');">&laquo;</a></li>';

        $html .= $previous_page;

        if ( $start > 1 ) {
            $html .= '<li><a href="#" onclick="changePage(1);">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ( $i = $start ; $i <= $end; $i++ ) {
            $class = ( $this->_page == $i ) ? "active" : "";
            $html .= '<li  class="' . $class . '"><a href="#" onclick="changePage(' . $i . ');">' . $i . '</a></li>';
        }

        if ( $end < $last ) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="#" onclick="changePage(' . $last . ');">' . $last . '</a></li>';
        }

        $class = ( $this->_page == $last ) ? "disabled" : "";

        $next_page = ( $this->_page == $last) ?
        '<li class="' . $class . '"><a href="#">&raquo;</a></li>' :
        '<li class="' . $class . '"><a href="#" onclick="changePage(' . ( $this->_page + 1 ) . ');">&raquo;</a></li>';

        $html .= $next_page;
        $html .= '</ul>';

        return $html;
    }
}
?>

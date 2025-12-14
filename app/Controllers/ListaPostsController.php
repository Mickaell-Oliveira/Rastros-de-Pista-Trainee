<?php

namespace App\Controllers;

use App\Core\App;

class ListaPostsController
{
    public function ListaPosts()
    {
        $itensPorPagina = 5;
        
        $host = "localhost";
        $db = "rastros_de_pista_db";
        $user = "root";
        $pass = "";

        $mysqli = new \mysqli($host, $user, $pass, $db);

        if($mysqli->connect_errno) {
            die("Falha na conexão do banco de dados");
        }

        $busca = $_GET['busca'] ?? "";
        $filtroTipo = $_GET['tipo'] ?? "";
        $filtroAno = $_GET['ano'] ?? "";
        $filtroTags = $_GET['tags'] ?? ""; 

        $pageSolicitada = isset($_GET['paginacaoNumero']) && !empty($_GET['paginacaoNumero']) ? (int)$_GET['paginacaoNumero'] : 1;

        $sql = "SELECT * FROM posts WHERE 1=1";
        $types = "";
        $params = [];

        if (!empty($busca)) {
            $sql .= " AND (titulo LIKE ? OR autor LIKE ? OR veiculo LIKE ? OR descricao LIKE ?)";
            $search_term = "%" . $busca . "%";
            $types .= "ssss";
            array_push($params, $search_term, $search_term, $search_term, $search_term);
        }

        if (!empty($filtroTipo)) {
            $sql .= " AND categoria = ?";
            $types .= "s";
            $params[] = $filtroTipo;
        }

        if (!empty($filtroAno)) {
            $sql .= " AND ano_veiculo = ?";
            $types .= "s";
            $params[] = $filtroAno;
        }

        if (!empty($filtroTags)) {
            $tagsArray = explode(',', $filtroTags);
            $tagClauses = [];
            foreach ($tagsArray as $tag) {
                $tagClauses[] = "(descricao LIKE ? OR titulo LIKE ?)";
                $types .= "ss";
                $params[] = "%" . trim($tag) . "%";
                $params[] = "%" . trim($tag) . "%";
            }
            if (!empty($tagClauses)) {
                $sql .= " AND (" . implode(" OR ", $tagClauses) . ")";
            }
        }

        $sql .= " ORDER BY data DESC";

        $stmt = $mysqli->prepare($sql);
        $posts = [];

        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                while ($row = $result->fetch_object()) {
                    $posts[] = $row;
                }
            }
        }

        $total_posts = count($posts);
        $total_pages = ceil($total_posts / $itensPorPagina);

        if ($total_pages < 1) {
            $total_pages = 1;
        }

        $pageCorreta = $pageSolicitada;

        if ($pageCorreta < 1) {
            $pageCorreta = 1;
        }

        if ($pageCorreta > $total_pages) {
            $pageCorreta = $total_pages;
        }

        if ($pageSolicitada != $pageCorreta) {
            $parametrosAtuais = $_GET;
            $parametrosAtuais['paginacaoNumero'] = $pageCorreta;
            $novaQueryString = http_build_query($parametrosAtuais);
            
            header("Location: ?" . $novaQueryString);
            exit;
        }

        $offset = ($pageCorreta - 1) * $itensPorPagina;
        $postsPaginados = array_slice($posts, $offset, $itensPorPagina);

        return view('site/posts_page', [
            'posts' => $postsPaginados,
            'page' => $pageCorreta,
            'total_pages' => $total_pages,
            'busca' => $busca,
            'filtroTipo' => $filtroTipo,
            'filtroAno' => $filtroAno,
            'filtroTags' => $filtroTags
        ]);
    }
}
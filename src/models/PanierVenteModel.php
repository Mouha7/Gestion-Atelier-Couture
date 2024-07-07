<?php

namespace Macbook\Models;

class PanierVenteModel
{
    public $client = null;
    public array $data = [];
    public $total = 0;
    public $qte = 0;
    public string $observations = '';

    public function addArticle($article, $client, $qteAppro, $obs)
    {
        $montantArticle = $this->montantArticle($article['prixVente'], $qteAppro);
        $key = $this->articleExist($article);
        if ($key != -1) {
            $this->data[$key]['qteAppro'] += $qteAppro;
            $this->data[$key]['montantArticle'] += $montantArticle;
        } else {
            $article['qteAppro'] = $qteAppro;
            $article['montantArticle'] = $montantArticle;
            $this->data[] = $article;
        }
        $this->observations = $obs;
        $this->qte += $qteAppro;
        $this->client = $client;
        $this->total += $montantArticle;
    }

    public function montantArticle($prix, $qteAppro)
    {
        return $prix * $qteAppro;
    }

    public function articleExist($article): int
    {
        foreach ($this->data as $key => $value) {
            if ($value["idArticle"] == $article["idArticle"]) {
                return $key;
            }
        }
        return -1;
    }

    public function clearPanier(): void
    {
        $this->data = [];
        $this->client = null;
        $this->qte = 0;
        $this->total = 0;
        $this->observations = '';
    }
}

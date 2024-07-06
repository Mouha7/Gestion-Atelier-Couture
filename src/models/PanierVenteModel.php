<?php

namespace Macbook\Models;

class PanierVenteModel
{
    public $fournisseur = null;
    public array $articles = [];
    public $total = 0;
    public $qte = 0;
    public string $observations = '';

    public function addArticle($article, $fournisseur, $qteAppro, $obs)
    {
        $montantArticle = $this->montantArticle($article['prixAchat'], $qteAppro);
        $key = $this->articleExist($article);
        if ($key != -1) {
            $this->articles[$key]['qteAppro'] += $qteAppro;
            $this->articles[$key]['montantArticle'] += $montantArticle;
        } else {
            $article['qteAppro'] = $qteAppro;
            $article['montantArticle'] = $montantArticle;
            $this->articles[] = $article;
        }
        $this->observations = $obs;
        $this->qte += $qteAppro;
        $this->fournisseur = $fournisseur;
        $this->total += $montantArticle;
    }

    public function montantArticle($prix, $qteAppro)
    {
        return $prix * $qteAppro;
    }

    public function articleExist($article): int
    {
        foreach ($this->articles as $key => $value) {
            if ($value["idArticle"] == $article["idArticle"]) {
                return $key;
            }
        }
        return -1;
    }

    public function clearPanier(): void
    {
        $this->articles = [];
        $this->fournisseur = null;
        $this->qte = 0;
        $this->total = 0;
        $this->observations = '';
    }
}

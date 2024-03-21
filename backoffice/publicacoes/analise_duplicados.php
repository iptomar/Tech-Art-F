<?php

class analise_duplicados
{
    private $titles;
    private $journals;
    private $volumes;
    private $numbers;
    private $pages;
    private $years;
    private $urls;
    private $authors;
    private $keywords;

    public function __construct($titles, $journals, $volumes, $numbers, $pages, $years, $urls, $authors, $keywords)
    {
        $this->titles = $titles;
        $this->journals = $journals;
        $this->volumes = $volumes;
        $this->numbers = $numbers;
        $this->pages = $pages;
        $this->years = $years;
        $this->urls = $urls;
        $this->authors = $authors;
        $this->keywords = $keywords;
    }

    public function checkSimilarity()
    {
        $potentialDuplicates = array();

        for ($i = 0; $i < count($this->titles); $i++) {
            for ($j = $i + 1; $j < count($this->titles); $j++) {

                $publication1title = $this->titles[$i];
                $publication1journal = $this->journals[$i];
                $publication1volume = $this->volumes[$i];
                $publication1number = $this->numbers[$i];
                $publication1page = $this->pages[$i];
                $publication1year = $this->years[$i];
                $publication1url = $this->urls[$i];
                $publication1author = $this->authors[$i];
                $publication1keyword = $this->keywords[$i];

                $publication2title = $this->titles[$j];
                $publication2journal = $this->journals[$j];
                $publication2volume = $this->volumes[$j];
                $publication2number = $this->numbers[$j];
                $publication2page = $this->pages[$j];
                $publication2year = $this->years[$j];
                $publication2url = $this->urls[$j];
                $publication2author = $this->authors[$j];
                $publication2keyword = $this->keywords[$j];

                if (strlen($publication1title) > 0 && strlen($publication2title) > 0) {
                    similar_text(trim(strtolower($publication1title)), trim(strtolower($publication2title)), $percenttitle);
                }
                if (strlen($publication1journal) > 0 && strlen($publication2journal) > 0) {
                    similar_text(trim(strtolower($publication1journal)), trim(strtolower($publication2journal)), $percentjournal);
                }
                if (strlen($publication1volume) > 0 && strlen($publication2volume) > 0) {
                    similar_text(trim(strtolower($publication1volume)), trim(strtolower($publication2volume)), $percentvolume);
                }
                if (strlen($publication1number) > 0 && strlen($publication2number) > 0) {
                    similar_text(trim(strtolower($publication1number)), trim(strtolower($publication2number)), $percentnumber);
                }
                if (strlen($publication1page) > 0 && strlen($publication2page) > 0) {
                    similar_text(trim(strtolower($publication1page)), trim(strtolower($publication2page)), $percentpage);
                }
                if (strlen($publication1year) > 0 && strlen($publication2year) > 0) {
                    similar_text(trim(strtolower($publication1year)), trim(strtolower($publication2year)), $percentyear);
                }
                if (strlen($publication1url) > 0 && strlen($publication2url) > 0) {
                    similar_text(trim(strtolower($publication1url)), trim(strtolower($publication2url)), $percenturl);
                }

                if (strlen($publication1author) > 0 && strlen($publication2author) > 0) {
                    similar_text(trim(strtolower($publication1author)), trim(strtolower($publication2author)), $percentauthor);
                }

                if (strlen($publication1keyword) > 0 && strlen($publication2keyword) > 0) {
                    similar_text(trim(strtolower($publication1keyword)), trim(strtolower($publication2keyword)), $percentkeyword);
                }

                if ($percenttitle > 90) {
                    $potentialDuplicates[] = array(

                        'publication1title' => $publication1title,
                        'publication2title' => $publication2title,
                        'percenttitle' => $percenttitle,

                        'publication1journal' => $publication1journal,
                        'publication2journal' => $publication2journal,
                        'percentjournal' => $percentjournal, 

                        'publication1volume' => $publication1volume,
                        'publication2volume' => $publication2volume,
                        'percentvolume' => $percentvolume,

                        'publication1number' => $publication1number,
                        'publication2number' => $publication2number,
                        'percentnumber' => $percentnumber,

                        'publication1page' => $publication1page,
                        'publication2page' => $publication2page,
                        'percentpage' => $percentpage,

                        'publication1year' => $publication1year,
                        'publication2year' => $publication2year,
                        'percentyear' => $percentyear,

                        'publication1url' => $publication1url,
                        'publication2url' => $publication2url,
                        'percenturl' => $percenturl,

                        'publication1author' => $publication1author,
                        'publication2author' => $publication2author,
                        'percentauthor' => $percentauthor,

                        'publication1keyword' => $publication1keyword,
                        'publication2keyword' => $publication2keyword,
                        'percentkeyword' => $percentkeyword

                    );
                }
            }
        }

        return $potentialDuplicates;
    }
}

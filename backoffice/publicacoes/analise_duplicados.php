<?php

class analise_duplicados
{
    private $publications;

    public function __construct($publications)
    {
        $this->publications = $publications;
    }

    public function checkSimilarity()
    {
        $potentialDuplicates = array();

        for ($i = 0; $i < count($this->publications); $i++) {
            for ($j = $i + 1; $j < count($this->publications); $j++) {
                $publication1 = $this->publications[$i];
                $publication2 = $this->publications[$j];

                similar_text(trim(strtolower($publication1)), trim(strtolower($publication2)), $percent);

                if ($percent > 90) {
                    $potentialDuplicates[] = array(
                        'publicacao1' => $publication1,
                        'publicacao2' => $publication2,
                        'similaridade' => $percent
                    );
                }
            }
        }

        return $potentialDuplicates;
    }
}

?>
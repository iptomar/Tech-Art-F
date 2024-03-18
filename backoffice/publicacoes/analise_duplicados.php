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

                similar_text($publication1, $publication2, $percent);

                if ($percent > 90) {
                    $potentialDuplicates[] = array(
                        'publication1' => $publication1,
                        'publication2' => $publication2,
                        'similarity' => $percent
                    );
                }
            }
        }

        return $potentialDuplicates;
    }
}

?>
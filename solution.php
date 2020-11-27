<?php
class Revers
{
    private $specialCharArray = ['!', '?', '.', ',', '"', ':', ';'];
    public function revertCharacters($string)
    {
        $string = preg_replace('/\s+/', ' ', $string);
        $splitString = explode(' ', $string);
        foreach ($splitString as &$word)
        {
            $firstChars = [];
            $lastChars = [];
            if (in_array($word[0], $this->specialCharArray)) {
                $word = $this->savePunctuation($word, $firstChars);

            }
            if ($this->checkLastChars($word)) {
                $word = strrev($word);
                $word = $this->savePunctuation($word, $lastChars);
                $word = strrev($word);
                $word = $this->wordRev($word);
            } else {
                $word = $this->wordRev($word);
            }
            if (!empty($lastChars)) {
                $word .= implode('', $lastChars);
            }
            if (!empty($firstChars)) {
                $firstChars = array_reverse($firstChars);
                $word = implode('', $firstChars) . $word;
            }
        }
        return implode(' ', $splitString);
    }

    private function savePunctuation($word, &$charArray)
    {
        $i = 0;
        $count = 0;
        $len = strlen($word);
        while ($i < $len)
        {
            if (in_array($word[$i], $this->specialCharArray)) {
                array_unshift($charArray, $word[$i]);
                $count++;
            } else {
                break;
            }
            $i++;
        }
        $word = substr($word, $count);
        return $word;
    }

    private function wordRev($word)
    {
        $i = 0;
        $j = strlen($word) - 1;
        while ($i < $j)
        {
            $flagLeft = $word[$i] === strtoupper($word[$i]);
            $flagRight = $word[$j] === strtoupper($word[$j]);
            $temp = ($flagRight) ? strtoupper($word[$i]) : strtolower($word[$i]);
            $word[$i] = ($flagLeft) ? strtoupper($word[$j]) : strtolower($word[$j]);
            $word[$j] = $temp;
            $i++;
            $j--;
        }
        return $word;
    }

    private function checkLastChars($word)
    {
        $lastSymbol = strlen($word) - 1;
        if (in_array($word[$lastSymbol], $this->specialCharArray)) {
            return 1;
        }
        return 0;
    }
}

$result = new Revers;
echo $result->revertCharacters('Marlene Dietrich rightly believed that "tenderness is a better proof of love than the most passionate vows...".') . "<br>";

/* -= тесты =- */
function testRevertCharacters()
{
    echo '-= Tests =- <br>';
    $revers = new Revers;
    $testString = 'Hi! Long time no see.';
    $result = $revers->revertCharacters($testString);
    if ($result === 'Ih! Gnol emit on ees.') {
        echo 'testRevertCharacters 1 - ok! <br>';
    } else {
        echo 'fail <br>';
    }
    $testString = 'Marlene Dietrich rightly believed that "tenderness is a better proof of love than the most passionate vows...".';
    $result = $revers->revertCharacters($testString);
    if ($result === 'Enelram Hcirteid ylthgir deveileb taht "ssenrednet si a retteb foorp fo evol naht eht tsom etanoissap swov...".') {
        echo 'testRevertCharacters 2 - ok! <br>';
    } else {
        echo 'fail <br>';
    }
    $testString = 'Ti   sAw   A   YrEv  gnItSerEtnI  !!.kSat.!!';
    $result = $revers->revertCharacters($testString);
    if ($result === 'It wAs A VeRy inTeResTinG !!.tAsk.!!') {
        echo 'testRevertCharacters 3 - ok! <br>';
    } else {
        echo 'fail <br>';
    }
}

/* -= Запуск теста =- */
testRevertCharacters();

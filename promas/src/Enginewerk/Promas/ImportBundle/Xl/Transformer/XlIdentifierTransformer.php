<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Transformer;

use Enginewerk\Promas\ImportBundle\Xl\Model\XlIdentifier;

class XlIdentifierTransformer
{
    /** @var string[] */
    private static $investment = [
        'BO' => 'bursztynowe-osiedle',
        'BPII' => 'barcinski-park-ii',
        'BPIII' => 'barcinski-park-iii',
        'BPIIIB' => 'barcinski-park-iii',
        'BPV' => 'barcinski-park-v',
        'BPVI' => 'barcinski-park-vi',
        // 'CP' => 'copernicus-park',	// Copernicus Park zostal polaczony z Copernicus Park II (i funkcjonuje jako copernicus-park-ii)
        'CP' => 'copernicus-park-ii',
        'CP2' => 'copernicus-park-ii',
        'CHO' => 'chabrowe-osiedle',
        'CHABR.II' => 'chabrowe-osiedle',
        'GH3' => 'garden-house-iii',
        'GH2' => 'garden-house-ii',
        'JARZEB.I' => 'osiedle-jarzebinowe',
        'JARZEB.II' => 'osiedle-jarzebinowe',
        'JARZEB.III' => 'osiedle-jarzebinowe',
        'KAS' => 'kasprzaka',
        'KRAKEU' => 'krakowska',
        'KE2' => 'krakowska-ii',
        'KSIECIA.W.' => 'ksiecia-warcislawa',
        'LIR' => 'lirowa',
        'LO' => 'lawendowe-osiedle',
        'LOII' => 'lawendowe-osiedle',
        'NC' => 'nowa-cegielnia',
        'NJ' => 'nad-jeziorem',
        'NAUT' => 'nautica',
        'NAUT2' => 'nautica-ii',
        'NAUT3' => 'nautica-iii',
        'NAUT4' => 'nautica-iv',
        'MM' => 'moja-malta',
        'OK' => 'osiedle-kolorowe',
        'OL' => 'lawendowe-osiedle',
        'OK2' => 'osiedle-kolorowe-ii',
        'OK3' => 'osiedle-kolorowe-ii', // 2015-10-28 mieszkania z etapu III sa dodane do etapu II
        'OK4' => 'kolorowe-osiedle-iii', // 2017-10-27 mieszkania z etapu IV sa dodane do etapu III
        'OMII' => 'osiedle-majowe',
        'OM' => 'osiedle-majowe',
        'PLAYA' => 'playa-baltis',
        'POZ' => 'osiedle-poziomkowe',
        'STCEG' => 'stara-cegielnia',
        'SWIT' => 'switezianki',
        'SA' => 'sokolowka-apartamenty', // stare NJ
        'SAIII' => 'sokolowka-ii',
        'TP' => 'tumski-park',
        'TB' => 'tarasy-bartycka',
        'VP' => 'villa-park',
        'W83' => 'wlodarzewska-83',
        'W65' => 'wlodarzewska-65',
    ];

    private static $fixMapping = [
        'SA_MI_A2.4.4_' => 'SA_MI_A2.4.4',
        'JARZEB.I_MI_A.5.1_A.5.2' => 'JARZEB.I_MI_Z.0.0'
    ];

    public function toXlIdentifier(string $identifier): XlIdentifier
    {
        $identifier = $this->substituteSpecialCharacters($identifier);

        try {
            $exploded = $this->explode($identifier);
        } catch (XlIdentifierParseException $exception) {
            $exploded = $this->explode($this->fixFormat($identifier));
        }

        $xlInvestmentName = $exploded[0];
        $xlInvestmentName = $this->transformXlInvestmentToPromasInvestment($xlInvestmentName);

        //$xlPropertyType = $exploded[1];
        $xlPropertyIdentifier = $this->unifyPropertyIdentifier($exploded[0], $identifier);

        return new XlIdentifier($xlInvestmentName, $exploded[1], $xlPropertyIdentifier);
    }

    private function explode(string $identifier): array
    {
        $exploded = explode(XlIdentifier::DELIMITER, $identifier);

        if (count($exploded) !== 3) {
            throw new XlIdentifierParseException(sprintf(
                'Unexpected number "%d" of components, expecting 3 in "%s"',
                count($exploded),
                $identifier
            ));
        }

        return $exploded;
    }

    private function fixFormat(string $identifier): string
    {
        if (array_key_exists($identifier, self::$fixMapping)) {
            $identifier = self::$fixMapping[$identifier];
        }

        return str_replace(' ', '_', $identifier);
    }

    private function substituteSpecialCharacters(string $input): string
    {
        $from = array('ą','ż','ź','ś','ć','ń','ę','ó','ł','Ą','Ż','Ź','Ś','Ć','Ń','Ę','Ó','Ł');
        $to =   array('a','z','z','s','c','n','e','o','l','A','Z','Z','S','C','N','E','O','L');

        return str_replace($from, $to, $input);
    }

    private function transformXlInvestmentToPromasInvestment(string $investmentName): string
    {
        if(!isset(static::$investment[$investmentName])) {
            throw new XlIdentifierInvestmentMappingException(sprintf(
                'Missing mapping for "%s"',
                $investmentName
            ));
        }

        return static::$investment[$investmentName];
    }

    private function unifyPropertyIdentifier(string $project, string $data): string
    {
        switch($project)
        {
            case 'KAS': // KAS_LN_U7
                if (strpos($data, 'KAS_MI') === 0) {
                    $data = $this->stripeAptCodeCustomA($data);
                    break;
                }
            // break ommited

            case 'NC': //NC_MI_D 1.1.1
                $data = str_replace("__",'_',$data);
                $data = explode('_', $data);
                $data[2] = str_replace(' ','',$data[2]);
                break;

            case 'OK': // OK_MI__J2.0.3
                $data = str_replace("I_4",'I4',$data);
                $data = str_replace(" ",'',$data);
                $data = str_replace("__",'_',$data);
                $data = explode('_', $data);
                $data[2] = str_replace(' ','',$data[2]);
                break;

            case 'BPV': // BPIV_MI_C 1.1.1		BPV_MI_D_1.1
                $data = str_replace("__",'_',$data);
                $data = str_replace("C_",'C',$data);
                $data = str_replace("D_",'D',$data);
                $data = explode('_', $data);
                $data[2] = str_replace(' ','',$data[2]);
                break;

            case 'NAUT2': //NAUT2_MI_B 0.1		NAUT2_MI_B_7.4
                $data = str_replace("__",'_',$data);
                $data = str_replace("B_",'B',$data);
                $data = explode('_', $data);
                $data[2] = str_replace(' ','',$data[2]);
                break;

            case 'NAUT3': // NAUT3_MI_C0.1	NAUT3_MI_C10.4	NAUT3_MI_C9.2
                $data = str_replace("MI_C",'MI_C.',$data);
                $data = explode('_', $data);
                break;

            case 'OM':
            case 'OMII':
            case 'BPIIIB': // BPIIIB_MI_F.3.5.2
                if(strpos($data,'BPIIIB_LN_H8') !== false) // BPIIIB_LN_H8.U1"
                {
                    $data = explode('_',$data);
                    $data[2] = str_replace('.','', $data[2]);
                    break;
                }
            case 'CP':
                $data = explode('_',$data);

                $aptCode = $data[2];
                $data[2] = $aptCode[0] . substr($aptCode, 2);
                break;

            case 'CP2': // CP2_MI_C.1.3
            case 'NS': //villa_park : E.3.4
            case 'RR': // RR_MI_E.3.3
            case 'BPVI': // A.1.0.1
            case 'KE2': // KE2_MI_K.4.2

                $data = explode('_',$data);

                $aptCode = $data[2];
                if($aptCode[1] === '.') {
                    $data[2] = $aptCode[0] . substr($aptCode, 2);
                }

                break;

            case 'VP': //villa_park : E.3.4
                $data = str_replace("D.1.3.",'D.1.3',$data);
                $data = str_replace("D.3.2P",'D.3.2',$data);
                $data = explode('_',$data);
                $aptCode = $data[2];
                if($aptCode[1] === '.') {
                    $data[2] = $aptCode[0] . substr($aptCode, 2);
                }
                break;

            case 'POZ':
                $data = str_replace(" ",'_',$data);
                $data = str_replace("__",'_',$data);
                $data = explode('_',$data);
                $data[2] = str_replace('.LU','',$data[2]);
                break;

            case 'OK2':
                // OK2_MI_A24.3
                // OK2_MI_B 0.3
                // OK2_MI_B_4.7
                $data = str_replace(' ','', $data);
                $data = str_replace('OK2_MI_A2', 'OK2_MI_A2.', $data);
                $data = str_replace('OK2_MI_A1', 'OK2_MI_A1.', $data);
                $data = str_replace('B_', 'B', $data);

                $data = explode('_', $data);
                break;

            case 'OK3':
                // OK3_MI_A1.0.1.
                $data = str_replace(' ','', $data);
                // usuwamy ostatnia kropke
                $data = rtrim($data, ".");

                $data = explode('_', $data);
                break;

            case 'MM':
                // Moja Malta
                // MM_MI_A7.2
                // MM_MI_B1.3.2
                $data = str_replace(' ','_',$data);
                $data = str_replace("__",'_',$data);
                // uslugowe maja dodatkowa kropke po U a przed 0 (zero)
                $data = str_replace("U0", "U.0", $data);

                $data = explode('_', $data);
                break;

            case 'JARZEB.I':
            case 'JARZĘB.I':
            case 'JARZEB.II':
            case 'JARZĘB.II':
                // Jarzebinowe Osiedle
                // JARZEB.I_MI_B 0.6
                // JARZEB.I_MI_A 3.2
                $data = str_replace("I_MI_A ",'I_MI_A.',$data);
                $data = str_replace("I_MI_B ",'I_MI_B.',$data);
                $data = explode('_',$data);
                break;

            case 'LOII':
                if (strrpos($data, '.') === strlen($data) - 1) {
                    $data = substr($data, 0, (strlen($data) - 1));
                }
                $data = explode('.', $data);
                $letter = $data[0];
                unset($data[0]);
                $data = $letter . implode('.', $data);
                $data = explode('_',$data);
                break;
            case 'OL':
            case 'LO':
                // Lawendowe Osiedle LO_MI_B.1.6, Lawendowe Osiedle II LOII_MI_E.1.3.3.
                // 2015-08-26 - Jeszcze nie wiadomo jak bedzie wygladalo oznaczenie w ASK-u - do ustalenia
                $data = str_replace(" ",'_', $data);
                $data = str_replace("__",'_', $data);
                $data = explode('_', $data);
                break;

            case 'SAIII':
                // Sokolowka II (w CDN-ie oznaczona jako Sokolowka etap III)
                // SAIII_MI_A 2.1
                // SAIII_MI_B.0.2
                // SAIII_MI_A.0.3
                // SAIII_MI_B_2.1
                $data = str_replace('A_2.', 'A.2.', $data);
                $data = str_replace('A ', 'A.', $data);
                $data = str_replace('B ', 'B.', $data);
                $data = str_replace('B_2', 'B.2', $data);
                $data = explode('_',$data);
                break;

            // W83_MI_E3.3
            // KSIĘCIA.W._MI_A0.1
            // TP_MI_B2.5.9
            // CHABR.II_MI_D2.6
            default:
                $data = str_replace(" ",'_',$data);
                $data = str_replace("__",'_',$data);
                $data = explode('_',$data);
                break;
        }

        return $data[2];
    }

    private function stripeAptCodeCustomA(string $data): array
    {
        $data = explode('_', $data);

        $aptCode = $data[2];

        if($aptCode[1] === '.') {
            $data[2] = $aptCode[0] . substr($aptCode, 2);
        }

        return $data;
    }

}

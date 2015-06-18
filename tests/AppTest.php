<?php


use TripleI\bus\App;

class AppTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group app
     * @group app-test1
     **/
    public function test1 ()
    {
        $data = $this->_getTestData(1);
        $app  = new App();
        $result = $app->execute($data[0][1]);

        $this->assertEquals($result, $data[0][2]);
    }


    /**
     * @test
     * @group app
     * @group app-test2
     **/
    public function test2 ()
    {
        $data = $this->_getTestData(0, 39);
        foreach ($data as $key => $d) {
            $app    = new App();
            $result = $app->execute($d[1]);
            $this->assertEquals($result, $d[2]);
        }
    }


    /**
     * テストデータを配列で取得する
     *
     * @param  int $offset
     * @param  int $raange
     * @return array
     **/
    private function _getTestData ($offset, $range = 1)
    {
        $test_data_path = ROOT.'/data/data.csv';

        $fp = @fopen($test_data_path, 'r');
        while ($row = fgetcsv($fp, 1000, ',')) {
            $i = intval($row[0]);
            if ($offset <= $i && $i < ($offset + $range)) {
                $results[] = $row;
            }
        }
        fclose($fp);

        return $results;
    }
}


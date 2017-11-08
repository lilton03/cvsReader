<?php


class CvsReader
{

    protected $fileName;
    protected $cvsKeys;
    protected $cvsData;
    protected $formattedCvsData;

    /*CVSReader Class Constructor*/
    function __construct($filName='')
    {
    $this->fileName=$filName;
    $this->cvsData='';
    $this->formattedCvsData=$this->cvsKeys=[];
    }

    /**
     * Format CVS string data into multi dimensional arrays like a data base table format
     * @return $this
     */
    public function formatCvsData()
    {
        $this->formattedCvsData = explode(',', $this->cvsData);
        $separator = count($this->cvsKeys);
        $replacementData = [[]];
        for ($y = $i = 0; $i <count($this->formattedCvsData)-$separator+1; $i += $separator-1) {
            for ($x = count($replacementData[$y]); $x < $separator - 1; $x++)
                $replacementData[$y][$this->cvsKeys[$x]] = $this->formattedCvsData[$i + $x];
            if (($i+$x) > 0 && (($i+$x) % ($separator - 1)) == 0) {
                $temp = explode(',', preg_replace('/\s+/',',',$this->formattedCvsData[$i + $x]));
                $replacementData[$y][$this->cvsKeys[$x]] = $temp[0];
                $y+=1;
                $replacementData[$y][$this->cvsKeys[0]] =$temp[1];
            }
        }
        unset($replacementData[count($replacementData)-1]);
        $this->formattedCvsData=$replacementData;
        return $this;
    }

    /**
     * Read CVS file
     * @return $this
     */
    public function readCvsData(){
        if($file=fopen(dirname(__FILE__).'/'.$this->fileName,'r')) {
            $this->cvsKeys = fgetcsv($file);
            $this->cvsData = fread($file, filesize(dirname(__FILE__).'/'.$this->fileName));
            fclose($file);
        }
        else
            printf("\n%s\n",'File Not Found');
        return $this;
    }

    /**
     * Write array of data into CVS file
     * @param $data
     * @return $this
     */
    public function writeToCvsFile($data){
        if($file=fopen(dirname(__FILE__).'/'.$this->fileName,'w+')){
            for($i=0;$i<count($data);$i++)
                fputcsv($file,$data[$i]);
            fclose($file);
            printf("\n%s\n",'Successfully updated file');
        }
        else
            printf("\n%s\n",'File Not Found');
        return $this;
    }

    /**
     * Return the un formatted cvs data string read from file
     * @return string
     */
    public function getCvsData(){
        return $this->cvsData;
    }

    /**
     * Return the formatted cvs data string read from file
     * @return array
     */
    public function getFormattedCvsData(){
        return $this->formattedCvsData;
    }

    /**
     * Get a CVS files key names like 'state','rate_area' etc
     * @return mixed
     */
    public function getCvsDataKeys(){
        return $this->cvsKeys;
    }

    /**
     * Set or change file name to read
     * @param $fileName
     * @return $this
     */
    public function setFileName($fileName){
        $this->fileName=$fileName;
        return $this;
    }

}
?>
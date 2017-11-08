Lilton A. Gungob
Code Sample
Email: liltongungob03@gmail.com

A php program for reading cvs files 



CvsReader class - is the class that reads and writes data back to the cvs file.
like so:

$cvReader=new CvsReader($fileName);
$cvsReader->readCvsData()->formatCvsData()->getFormattedCvsData();
$cvsReader->writeToCvsFile($data);


CvsQueryBuilder class - is the class that accepts the data returned from reading the CvsReader class,
and formats them into database table like structure.

like so:
$cvsDb=CvsQueryBuilder();

$cvsDb->addNewTable($tableName,$tableData);



@echo off

FOR /F "TOKENS=1-4* DELIMS=/" %%A IN ('DATE/T') DO (
 SET Year=%%C
 SET Month=%%B
 SET Day=%%A
)
FOR %%A IN (%Day%) DO SET Day=%%A
FOR %%A IN (%Month%) DO SET Month=%%A
FOR %%A IN (%Year%) DO SET Year=%%A

"C:\Arquivos de programas\Wamp\bin\mysql\mysql5.0.51b\bin\mysqldump" -u root -p --opt --default-character-set=latin1 --database sibib > F:\Sistema\backup\backup_%Day%-%Month%-%Year%.sql
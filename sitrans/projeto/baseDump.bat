@echo off

C:\"Program Files"\PostgreSQL\8.3\bin\pg_dump.exe -h localhost -p 5432 -U postgres -F c -b -v -f "D:\Web Pages\sitrans\projeto\base.dump" sitrans_date

pause
@echo off

C:\"Program Files"\PostgreSQL\8.2\bin\pg_dump.exe -h localhost -p 5432 -U postgres -F c -b -v -f "E:\Web Pages\sitrans\projeto\base.dump" sitrans

RMDIR /s /q "\\maverick\Web Pages\sitrans"

MKDIR "\\maverick\Web Pages\sitrans"

XCOPY /e/s/y "E:\Web Pages\sitrans" "\\maverick\Web Pages\sitrans"

pause
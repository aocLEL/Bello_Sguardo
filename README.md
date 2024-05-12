# Bello Sguardo (SMD)
This repository contains "Bello Sguardo", 2024 School Maker Day project presented by ISIT Bassi-Burgatti (Cento, FE)


Currently in active development...

Owners:
## - Notari Antonio
## - Chiodi Federico
## - Kiper Illia
## - Ravazza Marcello(teacher)

# Documentation:
## Compiling the project:
Due to the way in which Arduino-IDE handles program compilation, you have to add the BelloSguardo root folder path to Arduino-IDE Compiler options in order to solve all include directives in the code.
For do that , go to the `platforms.txt` file path, create a file named `platform.local.txt` and paste this content:
```
compiler.c.extra_flags=
compiler.c.elf.extra_flags=
compiler.S.extra_flags=
compiler.cpp.extra_flags=-I absolute_path_to_BelloSguardo/src
compiler.ar.extra_flags=
compiler.objcopy.eep.extra_flags=
compiler.elf2hex.extra_flags=
```
You may need to restart Arduino-IDE

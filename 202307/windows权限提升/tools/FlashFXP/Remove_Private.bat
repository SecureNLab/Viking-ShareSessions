REM Simple cleanup program to remove Private Installs of FlashFXP

REM Once a Private Install has been made users will not be able to switch to the same
REM global All User or Per User install all other users are using until this registry
REM setting is removed. This needs to be run from the users login.

reg delete HKCU\Software\FlashFXP\3 /v PrivateInstall /f
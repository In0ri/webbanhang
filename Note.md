OSCP Enumeration
================

May 3, 2020

I create my own checklist for the first but very important step: **Enumeration**.

Resources
---------

*   Useful exploits: https://github.com/jivoi/pentest

Port 80/443/8000/8080 - HTTP
----------------------------

### Web page

*   Open the web page, check http/https, check certificates to get users/emails
    
        # Identify features from the SSL certificate or SSL-based vulnerabilities (Heartbleed) on SSL-enabled services.
        sslscan $IP
        
    
*   Click the plugin [Wappalyzer](https://chrome.google.com/webstore/detail/wappalyzer/gppongmhjkpfnbhagpmjfkannfbllamg?hl=fr) to check web service & programming languages
    
*   Check `robots.txt` to get hidden folders: `curl -i $IP/robots.txt`
    
*   Run `nikto -h $IP -p $PORT`
    
*   Click all the links on the web page & always view page sources (`Ctrl + u`), focusing on `href`, comments or keywords like `password`, `login` , `upload`…
    
*   If directory `Allow: PUT`, try to upload text file then reverse shell through it
    
*   Get folders/files
    
        # Check folders with gobuster
        gobuster dir -u http://$IP -w /usr/share/wordlists/dirb/big.txt
        # Check files with gobuster (see Wappalyzer for correct file types)
        gobuster dir -u http://$IP/folder -w /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt -t 40
        gobuster dir -u http://$IP/folder -w /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt -x php,txt,html -t 40
        gobuster dir -u http://$IP/folder -w /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt -x php,txt,html,sh,cgi,js,css,py -t 40
        # First try some small wordlists
        gobuster -u http://$IP -w /usr/share/seclists/Discovery/Web_Content/Top1000-RobotsDisallowed.txt
        gobuster -u http://$IP -w /usr/share/seclists/Discovery/Web_Content/common.txt
        # With dirb 
        dirb http://$IP /usr/share/dirb/wordlists/big.txt
        # With dirsearch
        dirsearch.py -u http://$IP -e php -x 403,404 -t 50
        python3 dirsearch.py -u http://$IP -E
        
    
*   Download suspicious images & check: `exiftool $IMG`, `strings $IMG`, `xxd $IMG`, `steghide`, `binwalk $IMG`
    
*   For open-source services, could download the codes and browse files to have better understanding on their functionalities, parameters, …
    
*   `Searchsploit` for **every** service, software version
    
*   Check path traversal on [Linux](https://gracefulsecurity.com/path-traversal-cheat-sheet-linux/) and on [Windows](https://gracefulsecurity.com/path-traversal-cheat-sheet-windows/)
    

### Login forms

*   Check common creds: `admin/admin`, `admin/password`, `root/root`, `administrator/?`, `guest/guest` …
    
*   Search default creds of the web service on Google, documentations or usages (default users: `admin`, `root`, `[[email protected]](/cdn-cgi/l/email-protection)` …)
    
*   Capture `http-post-form` using BurpSuite
    
        # Extract strings from webpage and add them to password file / use rockyou.txt
        cewl -w passwords.txt -v http:IP
        # Create user file & bruteforce passwords using hydra
        hydra -L users.txt -P passwords.txt IP http-post-form LOGINFORM -V
        
    
*   Brute-force with [wfuzz](https://github.com/xmendez/wfuzz) using [SecLists’s passwords](https://github.com/danielmiessler/SecLists/tree/master/Passwords) ([tut](https://0ff5ec.com/hydra/))
    
        # Search for directories
        wfuzz -c -z file,/usr/share/wfuzz/wordlist/general/big.txt --hc 404 http://$IP/FUZZ
        # Search for user's password
        wfuzz -c -X POST -d "username=admin&password=FUZZ" -w ./darkweb2017-top10000.txt http://$IP/centreon/api/index.php?action=authenticate
        
    

### SQL injection

*   First try `'`, `1' or '1'='1-- -`, `' or '1'='1-- -`, `' or 1=1-- -`

#### Tutorials

*   Cheat sheet: http://pentestmonkey.net/cheat-sheet/sql-injection/mysql-sql-injection-cheat-sheet
    
*   [Types of SQL injection](https://www.imperva.com/learn/application-security/sql-injection-sqli/)
    
*   http://www.thegreycorner.com/2017/01/exploiting-difficult-sql-injection.html
    
*   Blind SQL injection
    
    *   [HTB-Falafel](https://0xdf.gitlab.io/2018/06/23/htb-falafel.html): write Python script to brute force admin’s password
*   HTB-Charon: change `UNION` to `UNIoN` to bypass the filter, bash script to enumerate a large number of rows in a table to get interesting creds
    
*   MariaDB
    
    *   [HHC2016 - Analytics](https://ippsec.rocks/holidayhack2016/part-4/): play with Burp Sequencer to capture the Cookies
*   Oracle SQL
    *   Tutorial: http://www.securityidiots.com/Web-Pentest/SQL-Injection/Union-based-Oracle-Injection.html
    *   https://www.doyler.net/security-not-included/oracle-command-execution-sys-shell
    *   Cheat sheet: http://pentestmonkey.net/cheat-sheet/sql-injection/oracle-sql-injection-cheat-sheet
*   MSSQL (Stacked Query)
    *   https://www.exploit-db.com/papers/12975
        
    *   https://perspectiverisk.com/mysql-sql-injection-practical-cheat-sheet/?\_ga=2.122859595.1915973150.1589228589-1090418158.1589228589
        
    *   http://pentestmonkey.net/cheat-sheet/sql-injection/mssql-sql-injection-cheat-sheet
        
    *   https://webcache.googleusercontent.com/search?q=cache:KtfxjonYw58J:https://perspectiverisk.com/mssql-practical-injection-cheat-sheet/+&cd=1&hl=en&ct=clnk&gl=fr http://www.securityidiots.com/Web-Pentest/SQL-Injection/MSSQL/MSSQL-Error-Based-Injection.html
        
    *   https://gracefulsecurity.com/sql-injection-cheat-sheet-mssql/
        
    *   Using `xp_cmdshell`:
        
        *   https://github.com/xMilkPowderx/OSCP/blob/master/SQLi.md, https://github.com/garyhooks/oscp/blob/master/**REFERENCE**/mssql.md
        *   [Cheatsheet](https://www.netsparker.com/blog/web-security/sql-injection-cheat-sheet/)
        *   HTB-Fighter
    *   Bypass filters: https://portswigger.net/support/sql-injection-bypassing-common-filters
        
    *   sqhs
        
            sqsh -S $IP -U $user -P $password
            
        
*   MySQL
    *   [Cheat sheet](http://pentestmonkey.net/cheat-sheet/sql-injection/mysql-sql-injection-cheat-sheet), https://gracefulsecurity.com/sql-injection-cheat-sheet-mysql/
    *   VH-DC 9: [tut](https://www.youtube.com/watch?v=_Aa8125CQ0g)
*   SQL Out-of-band exploitation
    
    *   (https://gracefulsecurity.com/sql-injection-out-of-band-exploitation/)
    *   HTB-Giddy
*   NoSQL
    
    *   https://github.com/swisskyrepo/PayloadsAllTheThings/tree/master/NoSQL%20Injection
    *   HTB-Mango

### LFI/RFI

*   Use Nikto, which will sometimes return LFI/RFI
    
*   Use Nmap’s HTTP NSE scripts
    
*   Check version names of the known CMS with know vulnerabilities, then simply Googling the version or whatever identifiable information
    
*   Bruteforce for directories and files, if PHPINFO() is present, check for allow\_url and other indicators
    
*   If all else fails, fuzz parameter passings. Try to understand what the application is doing, many times it’s obvious that the parameter is looking for another file, like to a webpage; I.e: whatever.php?=home // this is looking to grab “home” which is likely a file stored locally. Try removing the value home, see how the server reacts. Try to read local files you know should exist on the file, depending on the OS maybe /etc/passwd for Linux and boot.ini for Windows. Use PHP wrappers such as php://filter/convert.base64-encode/resource=index to try to read the actual file whatever.php’s source code. This will convert it to base64 to prevent execution via the webserver. Decode it and you get the source code. Watch verbose error messages
    

#### Tutorials

*   https://0ff5ec.com/lfi-rfi/
*   https://highon.coffee/blog/lfi-cheat-sheet/#how-to-get-a-shell-from-lfi
*   https://www.hackingarticles.in/5-ways-exploit-lfi-vulnerability/
*   https://medium.com/@Aptive/local-file-inclusion-lfi-web-application-penetration-testing-cc9dc8dd3601

### PHP

*   phpLiteAdmin: [VH-Zico2](https://www.hackingarticles.in/hack-zico2-vm-ctf-challenge/)
*   Simple PHP Blog (sphpblog): [VH-PwnOS](https://www.hackingarticles.in/hack-the-pwnos-2-0-boot-2-root-challenge/)

### Wordpress

*   Brute-force `http://$IP/wp-admin`, `http://$IP/wp-login.php`
    
        # Extract users, version
        wpscan --url http://$IP --enumerate
        # Brute-force creds (user: admin)
        wpscan --url http://$IP --wordlist rockyou.txt --username $USERS --max-threads 3
        # Ignore the SSL cert errordisable-tls-check
        wpscan -–url https://$IP disable-tls-check
        
    
*   Metasploit
    
    *   brute-force: `msf > use auxiliary/scanner/http/wordpress_login_enum`
*   Check `http://$IP/wp-content/themes`, `http://$IP/wp-content/uploads`
    
*   Possible attack vectors:
    *   After login, upload php reverse shell in `404.php` of a theme (`wp-content/themes/twentynineteen/404.php`)
    *   `msf > use exploit/unix/webapp/wp_admin_shell_upload`
    *   Upload malicious plugins in zip
*   Check interesting files: `/var/www/wp-config.php`
    
*   Check plugins’ vulnerability
    
    *   WordPress Plugin User Role Editor (https://www.exploit-db.com/exploits/44595): THM-Jack

#### Writeups

*   Upload shell: [VH-Stapler](https://www.hackingarticles.in/hack-stapler-vm-ctf-challenge/), [VH-Mr. Robot](https://www.hackingarticles.in/hack-mr-robot-vm-ctf-challenge/)
*   ReFlex Gallery plugin: [VH-Web Developer 1](https://www.hackingarticles.in/web-developer-1-vulnhub-lab-walkthrough/)
*   Activity Monitor plugin: [VH-DC06](https://www.hackingarticles.in/dc6-lab-walkthrough/)

### Joomla

*   [joomscan](https://github.com/rezasp/joomscan)
    
        joomscan -u http://$IP
        
    
*   [joomlavs](https://github.com/rastating/joomlavs)
    
*   Joomla 3.7.0 SQLi: https://github.com/XiphosResearch/exploits/tree/master/Joomblah
    

### Drupal

*   [droopscan](https://github.com/droope/droopescan)
    
        droopescan scan drupal -u http://$IP
        
    
*   Check `/CHANGELOG.txt` for Drupal version
    
*   Find `endpoint_path` and Services Endpoint
    
*   Attack vectors:
    
    *   Drupal 7.x Module Services - Remote Code Execution
    *   Drupalgeddon2 (March 2018): [exploit](https://github.com/dreadlocked/Drupalgeddon2)
    *   Drupalgeddon3 (April 2018): [exploit](https://raw.githubusercontent.com/oways/SA-CORE-2018-004/master/drupalgeddon3.py)

#### Tutorials

*   [Enumeration CMS web application](https://medium.com/@arnavtripathy98/pentesting-cms-web-applications-8b9f5c59fb6c)

#### Writeups

*   Drupal v7.54: [HTB-Bastard](https://hackingresources.com/bastard-hackthebox-walkthrough/)
*   VH-DC1

### Apache Tomcat

*   Try default creds in `/manager`: (tomcat/s3cret)
*   Deploy reverse shell in WAR format

#### Writeups

### WebDAV

Port 21 - FTP
-------------

*   nmap scripts in `/usr/share/nmap/scripts/`
    
        nmap -v -p 21 --script=ftp-anon.nse,ftp-bounce.nse,ftp-libopie.nse,ftp-proftpd-backdoor.nse,ftp-vsftpd-backdoor.nse,ftp-vuln-cve2010-4221.nse --script-args=unsafe=1 $IP
        
    
*   `searchsploit` FTP version
    
*   Metasploit
    
    *   Check version: `msf> use auxiliary/scanner/ftp/ftp_version`
    *   Anonymous login: `msf> use auxiliary/scanner/ftp/anonymous`
    *   Brute-force: `msf> use auxiliary/scanner/ftp/ftp_login`
*   Brute-force with hydra
    
        hydra -L user.txt -P passwords.txt $IP ftp
        
    
*   Check whether we can upload a shell, if so how to trigger the shell
    
        # If anonymous login is enable
        ftp $IP (anonymous/anonymous)
        telnet $IP 21
          
        # Recursively download whole ftp directories
        wget -m --no-parent --no-passive ftp://username:[email protected]
        # Interactive mode off & get all files
        prompt
        mget *
          
        # Change Binary mode (default Ascii mode) transfer to upload exe file
        binary
        ascii
          
        # Upload shell
        put shell
        # Get files for analysis
        get files
        
    
*   Examine configuration files: `ftpusers, ftp.conf, proftpd.conf`
    

### Tutorials

*   https://hackercool.com/2017/07/hacking-ftp-telnet-and-ssh-metasploitable-tutorials/

### Very Secure FTP Daemon (vsftpd)

#### Writeups

*   **v2.3.4** exploit
    
    *   [https://www.hackingtutorials.org/metasploit-tutorials/exploiting-vsftpd-metasploitable/](https://www.hackingtutorials.org/metasploit-tutorials/exploiting-vsftpd-metasploitable/)
    *   [HTB-Lame](https://0xdf.gitlab.io/2020/04/07/htb-lame.html), [HTB-LaCasaDePapel](https://0xdf.gitlab.io/2019/07/27/htb-lacasadepapel.html)
    
        msf> use exploit/unix/ftp/vsftpd_234_backdoor
        
    

### ProFTPd

#### Tutorials

*   https://hackercool.com/2020/03/hacking-proftpd-on-port-2121-and-hacking-the-services-on-port-1524/

Port 22 - SSH
-------------

*   Banner grab: `telnet $IP 22`
    
*   Try weak creds & Brute-force (exploitable in case of a very old version)
    
        hydra -L users.txt -P rockyou.txt $IP ssh
        hydra -l $USERNAME -P /usr/share/wordlists/wfuzz/others/common_pass.txt ssh://$IP
        
    
*   Crack passwords with john
    
        python ssh2john.py id_rsa > id_rsa.hash
        john --wordlist=rockyou.txt id_rsa.hash
        ssh -i /home/$username/.ssh/id_rsa $username@$IP
        
    
*   Examine configuration files: `ssh_config, sshd_config, authorized_keys, ssh_known_hosts, .shosts`
    
*   Proxychains
    
        # if ssh is filtered, add 'http $IP 3128' to /etc/proxychains.conf
        proxychains ssh $username@$IP /bin/bash
        # after get shell, find other internal services
        netstat -antp 
        
    
*   [RSA tool for ctf](https://github.com/Ganapati/RsaCtfTool): useful for decoding passwords
    
*   SSH with id\_rsa of a user
    
        chmod 600 id_rsa
        ssh -i id_rsa $username@$IP
        
    

#### Tutorials

*   https://community.turgensec.com/ssh-hacking-guide/

Port 23 - Telnet
----------------

*   Examine configuration files: `/etc/inetd.conf, /etc/xinetd.d/telnet, /etc/xinetd.d/stelnet`

#### Writeups

*   [HTB-Access](https://0xdf.gitlab.io/2019/03/02/htb-access.html)

Port 25 - SMTP
--------------

*   Connect
    
        telnet $IP 25
        nc $IP 25
        
    
*   nmap scripts
    
        nmap --script smtp-enum-users.nse -p 25 $IP
        
    
*   Run [smtp-user-enum](http://pentestmonkey.net/tools/user-enumeration/smtp-user-enum)
    
        # First prepare a list of usernames, enumerate valid usernames using the VRFY, EXPN, RCPT TO command 
        smtp-user-enum.pl -M VRFY -U users.txt -t $IP
        smtp-user-enum.pl -M EXPN -U users.txt -t $IP
        smtp-user-enum -M RCPT -U test-users.txt -t $IP
        # Enumerating valid email addresses of a domain (e.g., example.com)
        smtp-user-enum.pl -D example.com -M RCPT -U users.txt -t $IP
        
    
*   User enumeration (RCPT TO and VRFY) using [iSMTP](https://github.com/altjx/ipwn/tree/master/iSMTP)
    
        # Find valid email accounts
        ismtp -h $IP:25 -e emails.txt
        
    
*   Metasploit
    
    *   Search valid users: `use auxiliary/scanner/smtp/smtp_enum`

### Tutorials

*   https://hackercool.com/2017/06/smtp-enumeration-with-kali-linux-nmap-and-smtp-user-enum/

### Writeups

*   JAMES smtpd 2.3.2: [HTB-SolidState](https://0xdf.gitlab.io/2020/04/30/htb-solidstate.html)
*   Enumeration: [HTB-Reel](https://0xdf.gitlab.io/2018/11/10/htb-reel.html)
*   Postfix Shellshock: [exploit](https://github.com/3mrgnc3/pentest_old/blob/master/postfix-shellshock-nc.py)

Port 135, 136, 137, 138, 139 - Network Basic Input/Output System (NetBIOS)
--------------------------------------------------------------------------

#### Tutorials

*   https://www.hackingarticles.in/netbios-and-smb-penetration-testing-on-windows/

Port 445 - SBM
--------------

*   nmap scripts
    
        nmap -p139,445 --script smb-vuln-* $IP
        nmap -p139,445 --script=smb-enum-shares.nse,smb-enum-users.nse $IP
        
    
*   Find directories/files using [wordpress’s wordlist](https://github.com/danielmiessler/SecLists/blob/master/Discovery/Web-Content/CMS/wordpress.fuzz.txt)
    
*   Enumerate with [enum4linux](https://github.com/portcullislabs/enum4linux)
    
        enum4linux.pl -a $IP
        
    
*   Enumerate samba share drives with [smbmap](https://github.com/ShawnDEvans/smbmap)
    
        smbmap -H $IP
        smbmap -H $IP -u anonymous
        smbmap [-L] [-r] -H $IP -u $username -p $password -d $workgroup
        smbmap -H $IP -R --depth 5
        
    
*   Get files recursively from the shared folder
    
        smb> PROMPT OFF
        smb> RECURSE ON
        smb> mget *
        
    
*   smbclient ([http://www.madirish.net/59](http://www.madirish.net/59))
    
        smbclient -L $IP
        smbclient //$IP/tmp
        smbclient \\\\$IP\\ipc$ -U $username 
        smbclient //$IP/ipc$ -U $username
        
    
*   rpcclient
    
        nmblookup -A $IP
        rpcclient -U "" $IP
        
    
*   Mount shared folders
    
        mount -t cifs //$IP/$shared_folder $mount_folder
        
    
*   Metasploit
    
    *   `msf> use auxiliary/scanner/smb/smb2`
    *   `msf> use auxiliary/scanner/smb/smb_version`
    *   `msf> use auxiliary/scanner/smb/smb_enumshares`
    *   `msf> use auxiliary/scanner/smb/smb_enumusers`
    *   `msf> use auxiliary/scanner/smb/smb_login`
    *   `msf> use exploit/windows/smb/smb_delivery`
    *   EternalBlue (MS17-010): `msf> use exploit/windows/smb/ms17_010_eternalblue`
    *   `msf > use auxiliary/admin/smb/samba_symlink_traversal`
    *   [SambaCry CVE-2017-7494](https://github.com/betab0t/cve-2017-7494): `msf> use exploit/linux/samba/is_known_pipename`

#### Tutorials

*   https://medium.com/@arnavtripathy98/smb-enumeration-for-penetration-testing-e782a328bf1b
*   https://hackercool.com/2016/07/smb-enumeration-with-kali-linux-enum4linuxacccheck-smbmap/
*   https://www.hackingarticles.in/penetration-testing-in-smb-protocol-using-metasploit/
*   https://www.hackingarticles.in/multiple-ways-to-connect-remote-pc-using-smb-port/
*   https://www.hackingarticles.in/a-little-guide-to-smb-enumeration/

#### Writeups

*   MS-08-067, MS-17-010: [HTB-Legacy](https://0xdf.gitlab.io/2019/02/21/htb-legacy.html)

Ports 512, 513, 514 - Rexec & Rlogin
------------------------------------

### Tutorials

*   https://hackercool.com/2020/03/hacking-rexec-and-rlogin-services-on-ports-512-513-and-514/

Extra Resources
---------------

*   [http://www.0daysecurity.com/penetration-testing/enumeration.html](http://www.0daysecurity.com/penetration-testing/enumeration.html)
*   [https://gist.github.com/meldridge/d45a1886662a0b59f29bb94114163a0e](https://gist.github.com/meldridge/d45a1886662a0b59f29bb94114163a0e)
*   [https://cas.vancooten.com/posts/2020/05/oscp-cheat-sheet-and-command-reference/](https://cas.vancooten.com/posts/2020/05/oscp-cheat-sheet-and-command-reference/)
*   https://resources.infosecinstitute.com/what-is-enumeration/

Port 3306 - MySQL
-----------------

*   Connect the database
    
        sudo service mysql start
        mysql -u root -p
          
        mysql -h $IP –u root –p root
        mysql -h $IP –u $username –p $password
        
    
*   Decode passwords
    
        echo "$password" | base64 -d
        
    
*   Running as root: [raptor\_udf2 exploit](https://0xdeadbeef.info/exploits/raptor_udf2.c), [Lord of the Root CTF](https://highon.coffee/blog/lord-of-the-root-walkthrough/)
    

Port 3389 - Remote Desktop Protocol (RDP)
-----------------------------------------

    rdesktop -u $username -p $password $IP
    xfreerdp /u:$username /p:$password /v:$IP:3389
    

[](/2020/05/03/enum.html)

[![](//clustrmaps.com/map_v2.png?cl=8ec07c&w=384&t=n&d=xE6teuzDm91acciPP_WYoNhOMAHZqiOgAN7uOih7VnQ&co=282828)](https://clustrmaps.com/site/1ae0j "Visit tracker")

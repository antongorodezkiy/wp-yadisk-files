# The project is ARCHIVED and no longer maintained.

## jQuery-File-Upload dependency can be vulnerable.

### Please use on your own risk.

Please also note the following info about https://github.com/blueimp/jQuery-File-Upload plugin, which is included into the plugin (I received it from Igor Debatur, https://uploadcare.com/ ):

> [...] a major security issue that affects websites and applications using the Blueimp jQuery File Upload library, which is used by your wp-yadisk-files repository.

> [Publicized on October 18th](https://links8.mixmaxusercontent.com/596cc18e7f57bd3828257712/l/nNGM0pvMRnt5IstrB?messageId=HHiXPGxb5jM7TyIWS&rn=&re=iQXZu5yalh2Yhp3brBEZyFWdkVmI&sc=false) by the Akamai Security Intelligence Response Team and given the id [CVE-2018-9206](https://links3.mixmaxusercontent.com/596cc18e7f57bd3828257712/l/tzCVS9l3345r6ojib?messageId=HHiXPGxb5jM7TyIWS&rn=&re=iQXZu5yalh2Yhp3brBEZyFWdkVmI&sc=false) soon thereafter, this vulnerability allows attackers to trigger remote code execution.

> If you have not recently updated this library, you are very likely to be at risk of having your website or application compromised. The fix is to upgrade to the latest version and ensure that your Web server is configured to not execute files in the upload directory.

> [The exact details of who is affected and how to fix the vulnerability can be read here.](https://links3.mixmaxusercontent.com/596cc18e7f57bd3828257712/l/SBf47jahXXO1D7qFt?messageId=HHiXPGxb5jM7TyIWS&rn=&re=iQXZu5yalh2Yhp3brBEZyFWdkVmI&sc=false)

<?php
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Asad Haider <asad@asadhaider.co.uk>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package     FileEasy-Upload-Script
 * @author      Asad Haider <asad@asadhaider.co.uk>
 * @copyright   2012 Asad Haider.
 * @link        http://asadhaider.co.uk
 * @version     1.0.0
 */

include("./utils/config.php");
include("./utils/functions.php");

$page_name = "terms of service";
include("./utils/templates/header.php");
?>
  <div id="content">
    <div id="long_text">
      <h1>Terms of Service</h1>
      These Terms of Service set forth the terms and conditions upon which <?php echo ucwords($site_name); ?> makes available, at no charge, its file transmission services. Your use of the services is expressly conditioned on your compliance with these Terms of Service. By clicking accessing or using the services, you are indicating that you agree to be bound by these Terms of Service. You acknowledge and agree that <?php echo ucwords($site_name); ?> may revise these Terms of Service at any time. By continuing to access or use the services after <?php echo ucwords($site_name); ?> makes any such revision, you agree to be bound by the revised Terms of Service.
      <h2>Description of Services</h2>
      <?php echo ucwords($site_name); ?>'s service provides users with the ability to upload a file via HTTP-Protocol and receive a custom URL address to download the file from <?php echo ucwords($site_name); ?>'s servers. This address can be shared by the user freely and can be used to download the file a reasonable number of times. The address expires in an amount of time designated by the user (between 30 minutes and never) at which point in becomes inaccessible to the public and is removed from <?php echo ucwords($site_name); ?>'s servers.
      <h2>Content Availability</h2>
      <?php echo ucwords($site_name); ?> does not guarantee the quality or reliability of its services. Once a file has been uploaded to <?php echo ucwords($site_name); ?>'s servers, access to the file cannot be disabled before its designated expiration date. <?php echo ucwords($site_name); ?> reserves the right to remove any files at any time without notice.
      <h2>Privacy Policy</h2>
      <?php echo ucwords($site_name); ?> respects the privacy of its users and follows the privacy guidelines defined in our <a href="/privacy_policy">Privacy Policy</a>.
      <h2>Prohibited Use</h2>
      As a condition of your use of <?php echo ucwords($site_name); ?>'s services, you agree not to:
      <ul>
        <li>Upload or transmit any data, text, graphics, content, or material that: (i) is false or misleading; (ii) is defamatory; (iii) invades another's privacy; (iv) is obscene, pornographic, or offensive; (v) promotes bigotry, racism, hatred, or harm against any individual or group; (vi) infringes another's rights, including any intellectual property rights; or (vii) violates, or encourages any conduct that would violate, any applicable law or regulation or would give rise to civil liability;</li>
        <li>Access, tamper with, or use any non-public areas of the <?php echo ucwords($site_name); ?>'s systems or said system's providers;</li><li>Attempt to probe, scan, or test the vulnerability of the <?php echo ucwords($site_name); ?>'s systems or any related system or network or breach any privacy, security or authentication measures;</li>
        <li>Interfere with, or attempt to interfere with, the access of any user, host or network, including, without limitation, sending a virus, overloading, flooding, spamming, or mail-bombing <?php echo ucwords($site_name); ?>'s systems or providers; or</li>
        <li>Impersonate or misrepresent your affiliation with any person or entity.</li>
      </ul>
      <?php echo ucwords($site_name); ?> will have the right to investigate and prosecute violations of any of the above, including intellectual property rights infringement and security-related issues, to the fullest extent of the law. <?php echo ucwords($site_name); ?> may involve and cooperate with law enforcement authorities in prosecuting users who violate these Terms of Service. You acknowledge that <?php echo ucwords($site_name); ?> has no obligation to monitor your access to or use of the <?php echo ucwords($site_name); ?>'s services, but has the right to do so for the purpose of operating <?php echo ucwords($site_name); ?>'s, to ensure your compliance with these Terms of Service, or to comply with applicable law or the order or requirement of a court, administrative agency, or other governmental body.
      <h2>Warranties</h2>
      THE SERVICES ARE PROVIDED 'AS IS', WITHOUT WARRANTY OR CONDITION OF ANY KIND, EITHER EXPRESS OR IMPLIED. WITHOUT LIMITING THE FOREGOING, <?php echo strtoupper($site_name); ?> EXPLICITLY DISCLAIMS ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE OR NON-INFRINGEMENT. <?php echo strtoupper($site_name); ?> MAKES NO WARRANTY THAT THE SERVICES WILL MEET YOUR REQUIREMENTS OR WILL BE AVAILABLE ON AN UNINTERRUPTED, SECURE, OR ERROR-FREE BASIS. YOUR USE OF THE SERVICES IS AT YOUR OWN RISK. YOU ACKNOWLEDGE AND AGREE THAT <?php echo strtoupper($site_name); ?> WILL NOT BE RESPONSIBLE FOR ANY DAMAGES TO YOUR COMPUTER SYSTEM OR TO THE COMPUTER SYSTEM OF ANY THIRD PARTY THAT RESULT FROM USE OF THE SERVICES.
      <h2>Indemnity</h2>
      You agree to defend, indemnify, and hold harmless <?php echo ucwords($site_name); ?>, its officers, directors, employees and agents, from and against any claims, liabilities, damages, losses, and expenses, including, without limitation, reasonable legal and accounting fees, arising out of or in any way connected with your access to or use of the Services, or your violation of these Terms of Service.
      <h2>Limitation of Liability</h2>
      <?php echo strtoupper($site_name); ?> TAKES NO RESPONSIBILITY FOR THE CONTENT OF ITS USERS FILES. IN NO EVENT WILL <?php echo strtoupper($site_name); ?> BE LIABLE TO YOU OR TO ANY THIRD PARTY FOR ANY INCIDENTAL, SPECIAL, CONSEQUENTIAL OR PUNITIVE DAMAGES ARISING OUT OF OR IN CONNECTION WITH THESE TERMS OF SERVICE OR FROM THE USE OR INABILITY TO USE THE SERVICES OR ANY USER FILES SENT THROUGH, STORED BY OR DOWNLOADED FROM THE SERVICES, WHETHER BASED ON WARRANTY, CONTRACT, TORT (INCLUDING NEGLIGENCE) OR ANY OTHER LEGAL THEORY, AND WHETHER OR NOT <?php echo strtoupper($site_name); ?> HAS BEEN INFORMED OF THE POSSIBILITY OF SUCH DAMAGE, EVEN IF A REMEDY SET FORTH HEREIN IS FOUND TO HAVE FAILED OF ITS ESSENTIAL PURPOSE.
      <br/><br/>
      IN NO EVENT WILL <?php echo strtoupper($site_name); ?>'S AGGREGATE LIABILITY TO YOU OR TO ANY THIRD PARTY FOR ANY AND ALL CLAIMS ARISING OUT OF OR IN CONNECTION WITH THE USE OF THE SERVICES EXCEED ONE DOLLAR ($1). THE LIMITATIONS OF DAMAGES SET FORTH ABOVE ARE FUNDAMENTAL ELEMENTS OF THE BASIS OF THE BARGAIN BETWEEN <?php echo strtoupper($site_name); ?> AND YOU.
      <br/><br/>
      SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, SO THE ABOVE LIMITATION MAY NOT APPLY TO YOU.
      <h2>Severability</h2>
      In the event that any provision of these Terms of Service is held to be invalid or unenforceable, the remaining provisions of these Terms of Service will remain in full force and affect.
      <h2>Waiver</h2>
      The failure of <?php echo ucwords($site_name); ?> to enforce any right or provision of these Terms of Service will not be deemed a wavier of such right or provision.
      <h2>Entire Agreement</h2>
      These Terms of Service are the entire and exclusive agreement between <?php echo ucwords($site_name); ?> and you regarding <?php echo ucwords($site_name); ?>'s services, and these Terms of Service supersede and replace any prior agreements between <?php echo ucwords($site_name); ?> and you regarding the Services. You also may be subject to additional terms and conditions that may apply when you use or purchase certain other <?php echo ucwords($site_name); ?> services, affiliate services or third-party content software or services.
    </div>
  </div>
<?php
include("./utils/templates/footer.php");
?>
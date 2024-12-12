<?php require_once 'header.php'; ?>
  <h4>Update UPN</h4>

  <div class="row">
    <div class="eight columns">
      <p>Simply enter the target mailbox (comma separated) to get the PowerShell commands to change a leavers' UPN.</p>

      <form action="#" name="commands" method="post">
        <textarea class="u-full-width" placeholder="user@org.org.uk,user2@org.org.uk,user3@org.org.uk etc." name="mailbox" required="required"><?=isset($_POST['mailbox']) ? trim(htmlspecialchars($_POST['mailbox'])) : ''; ?></textarea>

        <input class="button-primary" type="submit" value="Submit" name="show-commands">
      </form>
    </div>
  </div>

<?php
if (isset($_POST['show-commands'])) {
  $mailboxarray = trim(str_replace(', ' , ',', htmlspecialchars($_POST['mailbox'])));
  $mailboxes = explode((','), $mailboxarray);
  $remove = array('-','_', ' ');
?>
  <h6>Here are the commands for the requested mailbox(es):</h6>

  <div>
    <strong>Connect to Microsoft:</strong><br>

    $LiveCred = Get-Credential<br>
    Connect-MSOLservice –Credential $livecred<br>
    $Session = New-PSSession -ConfigurationName Microsoft.Exchange -ConnectionUri https://ps.outlook.com/powershell/ -Credential $LiveCred -Authentication Basic -AllowRedirection<br>
    Import-PSSession $Session<br><br>
    If you have upgraded the Exchange PowerShell module run this:<br><br>Connect-ExchangeOnline<br>Connect-MSOLservice
  </div>

  <hr>

<?php
  foreach ($mailboxes AS $mailbox) {
    $email = str_replace('org.org.uk', 'org.onmicrosoft.com', strtolower($mailbox));
   
?>
  <div>
    Set-MsolUserPrincipalName -UserPrincipalName <?=$mailbox?> -NewUserPrincipalName <?=str_replace($remove, '', $email)?><br>
  </div>

<?php
  }
}
?>
</div>

</body>
</html>
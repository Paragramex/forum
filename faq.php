<?php

?><html lang="en">
  <head>
    <title>Board FAQ</title>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	?>
  </head>
  <body>
  <style>.answer { min-height: 300px; color:black; background-color: #61ff9e; width: 45%; height: 25vw; margin: 5px; overflow-y: scroll; min-width: 360px; max-width: 100%; } .answer * { color: black; }</style>
  <div id="contents"><ul>
  <li><a href="#register">Why Register?</a></li>
  <li><a href="#price">How much does it cost?</a></li>
  <li><a href="#bad_user">I registered but it says "Bad username"! Now what?</a></li>
  <li><a href="#rules">Are there any board rules?</a></li>
  <li><a href="#tags">What are tags?</a>
  <li><a href="#license">License for posted content</a></li>
  <li><a href="#admins">Who are the administrators?</a></li>
  <li><a href="#canibeanadmin">Great. Can I be an admin now?</a></li>
  <li><a href="#sockpuppetry">I got banned. Can I just create another account?</a></li>
  <li><a href="#private-messages">What are private messages?</a></li>
  <li><a href="#cp">I'm curious, what does the control panel look like?</a></li>
  </ul></div>
  <div style="display: flex; flex-direction: row; flex-wrap: wrap;">
  <div id="register" class="answer">
  <h2>Why register?</h2>
  You can do a lot more stuff!
  <table class="table">
  <tr><th>Item</th><th>Without account</th><th>With account</th></tr>
  <tr><td>Read chat</td><td>yes</td><td>yes</td></tr>
  <tr><td>Create topics</td><td>no</td><td>yes</td></tr>
  <tr><td>Participate in Chat</td><td>no</td><td>yes</td></tr>
  <tr><td>Create tags</td><td>no</td><td>yes</td></tr>
  <tr><td>Upload files</td><td>no</td><td>yes</td></tr>
  </table>
  You can register for free by clicking 'Sign Up' on the top bar.
  </div>
  <div id="price" class="answer">
	<h2>How much does it cost?</h2>
	It's free by default in the <a href="https://github.com/Paragramex/forum/blob/master/account/signup.php">software package</a>, but because we have the <a href="https://github.com/Paragramex/forum">source code</a> freely available, some forum owners looking to make money might enforce payments. If you upload the software without changing it, it's free to use.
  </div>
  <div id="bad_user" class="answer">
	<h2>I registered but it says "Bad username"! Now what?</h2>
	<ol><li>Check your username, it might have been misspelled.</li>
	<li>Check the <a href="users.php">list of users</a> to see if your username is there.</li>
	<li>If not, an administrator might have deleted it. Try registering again.</li></ol>
  </div>
  <div id="rules" class="answer">
  <h2>Are there any board rules?</h2>
  There's the <a href="tos.php">TOS</a>. Note that administrators can edit the TOS at any time, and they should notify the users of a TOS change by creating a topic. (There's a <a href="https://github.com/Paragramex/forum/blob/master/tos_raw.php">default TOS</a>, but administrators can edit it to match their rules. Be sure to review it from time to time!)
  </div>
  <div id="tags" class="answer">
	<h2>What are tags?</h2>
	<p>Tags categorize your topic into different categories. A person knowlegeable in one topic might check that tag for interesting topics.</p>
	<p>Tags look like this in a topic: <?php 
		$exampleTags = array(
			"html",
			"css",
			"meta",
			"faq",
			"announcement",
			"php"
		);
		foreach ($exampleTags as $tag) {
			?><span class="tag"><?php echo htmlspecialchars($tag); ?></span> <?php
		}
	?></p>
	<p>Tags are not case-sensitive. <span class="tag">PHP</span> is the same as <span class="tag">php</span>.</p>
	<ul>
		<li><div class="fakeinput">php sql</div> -> <span class="tag">php</span> <span class="tag">sql</span></li>
		<li><div class="fakeinput">php sql php</div> -> <span class="tag">php</span> <span class="tag">sql</span></li>
		<li><div class="fakeinput">PHP sql</div> -> <span class="tag">php</span> <span class="tag">sql</span></li>
	</ul>
	<p><strong>One really, really special note:</strong><br />NEVER tag-stuff! That means putting in unrelated tags just to increase your topic's visibility. If you persistently do this, you might get a warning, and if you fail to correct the behavior, you might get banned.</p>
  </div>
  <div id="license" class="answer">
	<h2>License for posted content</h2>
	By default, the license is the Creative Commons Attribution-ShareAlike 4.0 International License &lt;http://creativecommons.org/licenses/by-sa/4.0/>, although administrators can enforce a different one.
  </div>
  <div id="admins" class="answer">
	<h2>Who are the administrators?</h2>
	The person/people who set the board up. Administrators have access to more tools, so they can: <ul><li>Remove users if they violated the TOS or if the user requested account deletion</li><li>Browse, CHMOD, and delete uploaded files</li><li>Remove abusive content</li><li>Edit the TOS</li></ul>
  </div>
  <div id="canibeanadmin" class="answer">
	<h2>Can I be an admin?</h2>
	<p>Not right now. You need an administrator to add you manually to the list.</p>
  </div>
  <div id="sockpuppetry" class="answer">
	<h2>Creating multiple accounts</h2>
	<p>If you're acting as another person, <strong>this is illegal!</strong> If you are circumventing restrictions, it is also illegal. <a href="files/sockpuppetry.php">Download the sockpuppetry guidelines</a></p>
  </div>
  <div id="private-messages" class="answer">
	<h2>What are private messages?</h2>
	<p>You can send messages with this feature without exposing it to other users. Beware that because message contents are stored on the server, the owner might be able to see it.</p>
	<table class="table"><tr>
	<th>Appropriate for private messages</th>
	<th>Not appropriate for private messages</th></tr><tr>
	<td>Open-source code</td>
	<td>Confidential code</td>
	</tr><tr><td>Links to not-super-secret topics that you want someone else to hear about</td>
	<td>Profanity, inappropriate articles, or anything else that would lead to a ban in public</td></tr></table>
  </div>
  <div id="cp" class="answer">
	<h2>I'm curious, what does the control panel look like?</h2>
	<ul>
	<li><img width="100%" src="img/cp_1.png" alt="Control Panel Home" /></li>
	<li><img width="100%" src="img/cp_2.png" alt="Control Panel Files" /></li>
	</ul>
  </div>
  <div class="answer">
	<h2>Take me to the top!</h2>
	<a href="#contents">Sure.</a>
  </div>
  </div>
  </body>
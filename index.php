<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
	<title>AES Encryption and Decryption Tool</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/Index.css" type="text/css">
	<link href="css/bootstarp.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="js/jquery-3.7.1.min.js"></script>
	<!-- <script src="js/Navigation.js"></script> -->
	<script src="js/Index.js"></script>
</head>

<body>
	<div id="background">
		<?php include "Header.html" ?>
		<div id="body"><div><div style="height: 2120px;">
					<div class="featured" title="Advanced Encryption Standard">
						<div class="container mt-5" style="color: gray;">
							<div class="row">
								<p class="ml-3 mr-3 mt-3">Advanced Encryption Standard(AES) is a symmetric  encryption algorithm. AES is the industry standard as of now as it allows 128 bit, 192 bit and 256 bits encryption. Symmetric encryption is rapid as compared to asymmetric encryption and are used in systems such as database system. Following is an online tool to perform AES encryption and decryption of any plain-text or password.
								</p>
								<p class="ml-3 mr-3 mt-3">
								The tool provides multiple modes of encryption and decryption such as ECB, CBC, CTR and GCM mode. GCM is considered more secure than CBC mode and is widely adopted for its performance.
								</p>
								<div class="ml-3 mt-3">
									<h3>AES Encryption Terms & Terminologies
									<?php
										if (isset($_SESSION['email'])) {
											echo "<a href='javascript:void(0);' onclick='fnUserLogout();' title='Logout'>
											<img src='images/logout.png' height='30px' width='25px' alt='Logout' />
											</a>";
											$admin = ['idkhushirana@gmail.com','poojabarafwala09@gmail.com','prachichahhan@gmail.com'];
											if(in_array(strtolower($_SESSION['email']), $admin)){
												echo "<span><a href='/CipherNest/Aindex.php'><img src='images/Admin.png' title='Go Back To Admin' height='30px' width='30px'></a></span>";
											}
										}

										if (isset($_REQUEST['logout'])) {
												require 'DB.php';

												$EndDateTime = date('Y-m-d H:i:s');
												$email = $_SESSION['email'];
												
												$q = "select * from tblUserActivity where UID='$email' order by LastLoginDateTime desc limit 1";
												$res = mysqli_query($mysql,$q);
												while($r = mysqli_fetch_row($res)){
													$loginTime = new DateTime($r[2]);
													$logoutTime = new DateTime($EndDateTime);
													$duration = $loginTime->diff($logoutTime);

													$formattedDuration = $duration->format('%h hours %i minutes %s seconds');

													$q = "update tblUserActivity set LastLogoutDateTime='$EndDateTime',Status='InActive',Duration='$formattedDuration' where UID='$email' and LastLoginDateTime='$r[2]'";
													
													if(mysqli_query($mysql,$q)){
														session_destroy();
													}
												}
												header("Location: index.php");
												exit();
										}
									?>
								</h3>
									<p>
									For encryption, you can either enter the plain text or password that you want to encrypt. Now choose the block cipher mode of encryption.
									</p>
								</div>
								<!-- Encryption Section -->
								<div class="col-sm-6 mt-3">
									<h4>AES Encryption</h4>
									<form id="aesEncryptForm" method="POST">
										<div class="form-group">
											<label for="plaintext">
												Enter Plain Text to Encrypt
											</label>
											<textarea class="form-control" id="plaintext" rows="4" required></textarea>	
										</div>
										<div class="form-group">
											<label for="cipherModeEncrypt">Select Cipher Mode of Encryption
												<i class="fas fa-question-circle mark-que"
														data-bs-toggle="tooltip" 
														data-bs-placement="top" 
														title="Block cipher modes process data in fixed-size blocks. If the last fragment of data is smaller than the block size, it needs to be padded with extra bytes to fill the entire block before encryption or decryption can take place.">
													</i>
											</label>
											<select class="form-control" id="cipherModeEncrypt">
												<option value="CBC">CBC (Cipher Block Chaining)</option>
												<option value="CTR">CTR (Counter Mode)</option>
												<option value="GCM">GCM (Galois/Counter Mode)</option>
												<option value="ECB">ECB (Electronic Codebook)</option>
											</select>
										</div>
										<div class="form-group">
											<label for="keySizeEncrypt">Key Size in Bits
												<i class="fas fa-question-circle mark-que" 
														data-bs-toggle="tooltip" 
														data-bs-placement="top" 
														title="A n bit key means - A brute-force attack will need a maximum complexity of 2^n to find the correct key.">
													</i>
											</label>
											<select class="form-control" id="keySizeEncrypt">
												<option value="128">128</option>
												<option value="192">192</option>
												<option value="256">256</option>
											</select>
										</div>
										<div class="form-group">
											<label for="secretKeyEncrypt">Enter Secret Key
												<i class="fas fa-question-circle mark-que"
													data-bs-toggle="tooltip" 
													data-bs-placement="top" 
													title="If key size is 128 then 'mySecretKey1234' is a valid secret key because it has 16 characters i.e 16 * 8 = 128 bits.">
												</i>
											</label>
											<input type="text" class="form-control"  id="secretKeyEncrypt" required oninput="checkKeyLength_Enc()">
										</div>
										<div class="form-group row ml-1">
											<label>Output Text Format </label>&nbsp;
											<div class="form-check col-sm-2">
												<input class="form-check-input" type="radio" name="outputFormatEncrypt" id="base64"
													value="Base64" checked>
												<label class="form-check-label" for="base64">Base64</label>
											</div>
											<div class="form-check col-sm-2">
												<input class="form-check-input" type="radio" name="outputFormatEncrypt" id="hex" value="Hex">
												<label class="form-check-label" for="hex">Hex</label>
											</div>
										</div>
										<button type="button"  onclick="encryptText();">Encrypt</button>
									</form>

									<h4 class="mt-4">AES Encrypted Output</h4>
									<textarea class="form-control" placeholder="Result goes here" id="outputEncrypt" rows="4" readonly></textarea>
								</div>

								<!-- Decryption Section -->
								<div class="col-sm-6 mt-3">
									<h4>AES Decryption 
										<a href="javascript:void(0);" onclick="ClearControls();" title="Click To Refresh All"><img src="images/RefreshAll.png" height="30px" width="30px" alt="Refresh" style="float: right;"/></a>
									
								</h4>
									
									<form id="aesDecryptForm" method="POST">
										<div class="form-group">
											<label for="encryptedText">AES Encrypted Text</label>
											<textarea class="form-control" id="encryptedText" rows="4" required></textarea>
										</div>
										<div class="form-group">
											<label for="cipherModeDecrypt">Select Cipher Mode of Decryption
													<i class="fas fa-question-circle mark-que" 
														 
														data-bs-toggle="tooltip" 
														data-bs-placement="top" 
														title="Block cipher modes process data in fixed-size blocks. If the last fragment of data is smaller than the block size, it needs to be padded with extra bytes to fill the entire block before encryption or decryption can take place.">
													</i>
											</label>
											<select class="form-control" id="cipherModeDecrypt">
												<option value="CBC">CBC (Cipher Block Chaining)</option>
												<option value="CTR">CTR (Counter Mode)</option>
												<option value="GCM">GCM (Galois/Counter Mode)</option>
												<option value="ECB">ECB (Electronic Codebook)</option>
											</select>
										</div>
										<div class="form-group">
											<label for="keySizeDecrypt">Key Size in Bits
												<i class="fas fa-question-circle mark-que"
														data-bs-toggle="tooltip" 
														data-bs-placement="top" 
														title="A n bit key means - A brute-force attack will need a maximum complexity of 2^n to find the correct key.">
													</i>
											</label>
											<select class="form-control" id="keySizeDecrypt">
												<option value="128">128</option>
												<option value="192">192</option>
												<option value="256">256</option>
											</select>
										</div>
										<div class="form-group">
											<label for="secretKeyDecrypt">Enter Secret Key used for Encryption
												<i class="fas fa-question-circle mark-que" 
													data-bs-toggle="tooltip" 
													data-bs-placement="top" 
													title="If key size is 128 then 'mySecretKey1234' is a valid secret key because it has 16 characters i.e 16 * 8 = 128 bits.">
												</i>
											</label>
											<input type="text" class="form-control" id="secretKeyDecrypt" required>
										</div>
										<div class="form-group row ml-1">
											<label>Output Text Format </label>&nbsp;
											<div class="form-check col-sm-2">
												<input class="form-check-input" type="radio" name="outputFormatDecrypt" id="base64Decrypt"
													value="Base64">
												<label class="form-check-label" for="base64Decrypt">Base64</label>
											</div>
											<div class="form-check col-sm-4">
												<input class="form-check-input" type="radio" name="outputFormatDecrypt" id="plainText"
													value="PlainText" checked>
												<label class="form-check-label" for="plainText">Plain Text</label>
											</div>
										</div>
										<button type="button"  onclick="decryptText();">Decrypt</button>
									</form>

									<h4 class="mt-4">AES Decrypted Output</h4>
									<textarea class="form-control" placeholder="Decrypted result goes here" id="outputDecrypt" rows="4" readonly></textarea>
								</div>
								<article class="ml-3 mt-3 mr-3">
									<h3>Key Features</h3>
									<ul>
										<li>
											<strong>Symmetric</strong> Key Algorithm 	: Same key is used for both encryption and decryption.
										</li>
										<li>
											<strong>Block Cipher</strong> : AES operates on fixed-size blocks of data. The standard block size is 128 bits.
										</li>
										<li>
											<strong>Key Lengths</strong> : AES supports key lengths of 128, 192, and 256 bits. The longer the key, the stronger the encryption.

										</li>
										<li>
											<strong>Security</strong> : AES is considered very secure and is widely used in various security protocols and applications.
										</li>
									</ul>
								</article>
								<div class="ml-3 mt-3 mr-3">
									<h3>Different Supported Modes of AES Encryption</h3>
									AES offers multiple modes of encryption such as ECB, CBC, CTR, OFB, CFB and GCM mode.
									<ul class="mt-1">
										<li class="mt-1">
										ECB(Electronic Code Book) is the simplest encryption mode and does not require IV for encryption. The input plain text will be divided into blocks and each block will be encrypted with the key provided and hence identical plain text blocks are encrypted into identical cipher text blocks.
										</li>
										<li class="mt-1">
										CBC(Cipher Block Chaining) mode is highly recommended, and it is an advanced form of block cipher encryption. It requires IV to make each message unique meaning the identical plain text blocks are encrypted into dissimilar cipher text blocks. Hence, it provides more robust encryption as compared to ECB mode, but it is a bit slower as compared to ECB mode. If no IV is entered then default will be used here for CBC mode and that defaults to a zero-based byte[16].
										</li>
										<li class="mt-1">
										CTR(Counter) CTR mode (CM) is also known as integer counter mode (ICM) and segmented integer counter (SIC) mode. Counter-mode turns a block cipher into a stream cipher. CTR mode has similar characteristics to OFB, but also allows a random-access property during decryption. CTR mode is well suited to operate on a multiprocessor machine, where blocks can be encrypted in parallel.
										</li>
										<li class="mt-1">
										GCM(Galois/Counter Mode) is a symmetric-key block cipher mode of operation that uses universal hashing to provide authenticated encryption. GCM is considered more secure than CBC mode because it has built-in authentication and integrity checks and is widely used for its performance.
										</li>
									</ul>
								</div>	
								<div class="ml-3 mt-3 mr-3">
									<h3>AES Key Size</h3>
									<p>
									The AES algorithm has a 128-bit block size, regardless of whether your key length is 256, 192 or 128 bits. When a symmetric cipher mode requires an IV, the length of the IV must be equal to the block size of the cipher. Hence, you must always use an IV of 128 bits (16 bytes) with AES.
									</p>
								</div>
								<div class="ml-3 mt-3 mr-3">
									<h3>AES Secret Key</h3>
									<p>
									AES provides 128 bits, 192 bits and 256 bits of secret key size for  encryption. If you are selecting 128 bits for encryption, then the secret key must be of 16 bits long and 24 and 32 bits for 192 and 256 bits of key size respectively. For example, if the key size is 128, then a valid secret key must be of 16 characters i.e., 16*8 = 128 bits <br><br>
									Now you can enter the secret key accordingly. By default, the encrypted text will be base64 encoded, but you have options to select the output format as HEX too.<br><br>
									Similarly, for image and .txt file the encrypted form will be Base64 encoded.<br><br>
									AES decryption has also the same process. By default, it assumes the entered text be in Base64 and the final decrypted output will be a plain-text string.
									</p>
									<p>
										<center><h3>Thank you for visiting us! </h3>
										If you’re experiencing issues and concerns about this website,please feel free to reach out to us at,
										<a href="mailto:contact.me.at.khushirana@gmail.com"><img style="vertical-align: bottom;" src="images/ContactUs2.png" height="25px" width="25px" alt="Contact Us"></a>
										</center>
									 </p>
								</div>
							</div>
						</div>
					</div>
				</div></div></div>
		<?php include "Footer.html" ?>
	</div>
</body>

</html>

<!-- @version 1.0.0
	 @author Alexandra Debish
	 @last-updated Jan 28, 2015

Copyright (c) 2015 Accusoft Corporation

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. -->

<?php 
include('./ACSViewer.php');

$viewer = new ACSViewer(array(
  'key' => 'K2092014193734',
  'document' => 'http://images.accusoft.com/documents/prizm-cloud_slides.pdf',
  'toolbarColor' => '000000',
  'printButton' => 'no'
));

$text = $viewer->getDocumentText();
$content = $viewer->getContent();
?>

<!DOCTYPE html>
<html>
<head>
  <title>ACS Viewer Test File</title>
</head>

<body>

  <div>
  <h2>Document Text</h2>
  <?php echo $text; ?>
  </div>
  <hr />
  <div>
  <h2>The Viewer</h2>
  <?php echo $content; ?>
  </div>

</body>

</html>
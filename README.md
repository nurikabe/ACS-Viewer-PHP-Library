# Accusoft Cloud Services Viewer Libraries - PHP

This is a library to easily integrate the ACS Viewer into any webpage using PHP.

> ACS Viewer is a document viewer that enables you to display hundreds of different kinds of files on your website without worrying about whether your visitors have the software to view them and without installing any additional hardware or software. The document files stay on your server, so you can update, edit and change them anytime. Prizm Viewer supports more than 300 file types, including DOC, PDF, PPT, XLS and CAD.

### Getting an Accusoft Cloud Services key

A key is required to use the ACS viewer and its libraries. To get a key you have two options:
1. [Sign up] for a free Accusoft Cloud Services account, and generate your own personalized key there
2. Or you can use our temporary api key: K2092014193734

### Parameters
**Required Parameters**

- **key**: your api key, recieved in one of the two ways mentioned above
- **document**: The direct url to the document you wish to display

**Optional Viewer Parameters**

- **viewerType**: Choosing between either the html5 viewer or the slideshow version (html5 | slideshow)
- **viewerwidth**: Sets the width of the viewer in either % or px (int)
- **viewerheight**: Sets the height of the viewer in either % or px (int)
- **logoImage**: Changes the logo image that displays before the viewer is loaded (url)
- **toolbarColor**: Changes the color of the toolbar using hex color codes without the # (i.e. FFFFFF)

**Optional Slideshow Parameters**

- **animSpeed**: Sets the amount of time between slide changes in ms (int)
- **automatic**: Should the slideshow start and rotate automatically (yes | no)
- **showControls**: Should the controls display on hover? (yes | no)
- **centerControls**: Should the controls be centered or at the top of the slideshow (yes | no)
- **keyboardNav**: Allow for keyboard navigation (yes | no)
- **hoverPause**: Should the slideshow pause on hover? (yes | no)

---

## The PHP Library

### Initializing the viewer
```sh
include('ACSViewer.php');

$viewer = new ACSViewer(array(
  'key' => 'K2092014193734',
  'document' => 'http://images.accusoft.com/documents/prizm-cloud_slides.pdf',
  'toolbarColor' => '000000',
  'printButton' => 'yes'
));
```

### getDocumentText()
The getDocumentText() function makes a call to the api to extract the plain text directly from the document you specify. Displaying this on your page can make content easier to read, makes it more accessible, and can help boost your page's SEO.
```sh
echo $viewer->getDocumentText(); // the plain document text pulled from the file
```


### getContent()
The getContent() function returns the viewer itself with all the parameters you defined when initializing the viewer.
```sh
echo $viewer->getContent(); // the viewer with the defined parameters
```

---

Version
----
1.0.0

License
----
MIT

[sign up]:https://cloudportal.accusoft.com/

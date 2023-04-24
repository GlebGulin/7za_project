
USETEXTLINKS = 1
STARTALLOPEN = 0
HIGHLIGHT = 0
PRESERVESTATE = 1

// NOTE:  If you are going to set USEICONS = 1, then you will want to edit the gif
// files and remove the white space on the right
USEICONS = 1

// In this case we want the whole tree to be built, even those branches that are
// closed. The reason is that otherwise some form elements might not be built at
// all before the user presses the "Get Values" button.
BUILDALL = 1


// Some auxiliary functions for the contruction of the tree follow.  You will
// certainly want to change these functions for your own purposes.
//
// These functions are directly related with the additional JavaScript in the
// page holding the tree (demoCheckboxLeftFrame.html), where the form handling
// code resides.

// If you want to add checkboxes to the folder, you will have to create a function
// similar to this one and then call it in the tree construction section below.
function generateCheckBox(parentfolderObject, itemLabel, checkBoxDOMId, value, useCheckbox, checked) {
  var newObj;

  // For an explanation of insDoc and gLnk, read the online instructions.
  // They are the basis upon which TreeView is based.
  newObj = insDoc(parentfolderObject, gLnk("S", itemLabel, "javascript:selectItem("+value+")"))

  // The trick to show checkboxes in a tree that was made to display links is to
  // use the prependHTML. There are general instructions about this member
  // in the online documentation.
  if (useCheckbox)
      newObj.prependHTML = "<td valign=middle><input type=checkbox id="+checkBoxDOMId+" name='prod"+value+"' value="+value+(checked==1?' checked':'')+"></td>"
}

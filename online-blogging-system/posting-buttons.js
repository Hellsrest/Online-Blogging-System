//for bold
document.getElementById('boldButton').addEventListener('click', function() {
  const editor = document.getElementById('editor');
  const selection = window.getSelection();
  const range = selection.getRangeAt(0);
  const selectedText = selection.toString();

  if (selectedText) {
      let parentNode = range.commonAncestorContainer.parentNode;
      if (parentNode.nodeName === 'B') {
          document.execCommand('removeFormat');
      } else {
          document.execCommand('bold');
      }
  }
  selection.removeAllRanges();
  selection.addRange(range);
});

//for italic
document.getElementById('italicButton').addEventListener('click', function() {
  const editor = document.getElementById('editor');
  const selection = window.getSelection();
  const range = selection.getRangeAt(0);

  if (selection.rangeCount > 0 && !selection.isCollapsed) {
      const selectedText = selection.toString();
      let parentNode = range.commonAncestorContainer.parentNode;
      if (parentNode.nodeName === 'I') { 
          document.execCommand('removeFormat');
      } else {
          document.execCommand('italic');
      }
  }
  selection.removeAllRanges();
  selection.addRange(range);
});

//for strikethrough
document.getElementById('strikeButton').addEventListener('click', function() {
  const editor = document.getElementById('editor');
  const selection = window.getSelection();
  const range = selection.getRangeAt(0);

  if (selection.rangeCount > 0 && !selection.isCollapsed) {
      const selectedText = selection.toString();
      let parentNode = range.commonAncestorContainer.parentNode;

      if (parentNode.nodeName === 'S') {
          document.execCommand('removeFormat');
      } else {
          document.execCommand('strikethrough');
      }
  }
  selection.removeAllRanges();
  selection.addRange(range);
});

//for left-align
document.getElementById('leftAlignButton').addEventListener('click', function() {
  const editor = document.getElementById('editor');
  const selection = window.getSelection();
  const range = selection.getRangeAt(0);

  if (selection.rangeCount > 0 && !selection.isCollapsed) {
      const selectedText = selection.toString();
      let parentNode = range.commonAncestorContainer.parentNode;
      if (parentNode.style && parentNode.style.textAlign === 'left') {
          parentNode.style.textAlign = '';
      } else {
          document.execCommand('justifyLeft');
      }
  }
  selection.removeAllRanges();
  selection.addRange(range);
});

//for rightalign
document.getElementById('rightAlignButton').addEventListener('click', function() {
  const editor = document.getElementById('editor');
  const selection = window.getSelection();
  const range = selection.getRangeAt(0);

  if (selection.rangeCount > 0 && !selection.isCollapsed) {
      const selectedText = selection.toString();
      let parentNode = range.commonAncestorContainer.parentNode;
      if (parentNode.style && parentNode.style.textAlign === 'right') {
          parentNode.style.textAlign = '';
      } else {
          document.execCommand('justifyRight');
      }
  }
  selection.removeAllRanges();
  selection.addRange(range);
});
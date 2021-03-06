if (!window.DHTMLSuite) var DHTMLSuite = new Object()
let JSTreeObj
let treeUlCounter = 0
const nodeId = 1
DHTMLSuite.JSDragDropTree = function () {
  let idOfTree
  let folderImage
  let plusImage
  let minusImage
  let maximumDepth
  let dragNode_source
  let dragNode_parent
  let dragNode_sourceNextSib
  let dragNode_noSiblings
  let dragNode_destination
  let floatingContainer
  let dragDropTimer
  let dropTargetIndicator
  let insertAsSub
  let indicator_offsetX
  let indicator_offsetX_sub
  let indicator_offsetY
  let messageMaximumDepthReached
  let ajaxObjects
  let layoutCSS
  let cookieName
  this.folderImage = 'DHTMLSuite_folder.gif'
  this.plusImage = 'DHTMLSuite_plus.gif'
  this.minusImage = 'DHTMLSuite_minus.gif'
  this.maximumDepth = 6
  this.layoutCSS = 'drag-drop-folder-tree.css'
  this.floatingContainer = document.createElement('UL')
  this.floatingContainer.style.position = 'absolute'
  this.floatingContainer.style.display = 'none'
  this.floatingContainer.id = 'floatingContainer'
  this.insertAsSub = false
  document.body.appendChild(this.floatingContainer)
  this.dragDropTimer = -1
  this.dragNode_noSiblings = false
  this.cookieName = 'DHTMLSuite_expandedNodes'
  if (document.all) {
    this.indicator_offsetX = 1
    this.indicator_offsetX_sub = 1
    this.indicator_offsetY = 13
  } else {
    this.indicator_offsetX = 1
    this.indicator_offsetX_sub = 3
    this.indicator_offsetY = 5
  }
  if (navigator.userAgent.indexOf('Opera') >= 0) {
    this.indicator_offsetX = 2
    this.indicator_offsetX_sub = 3
    this.indicator_offsetY = -7
  }
  this.messageMaximumDepthReached = ''
  this.ajaxObjects = new Array()
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects()
  } catch (e) {
    alert('Include the dhtmlSuite-common.js file')
  }
  let objectIndex
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this
}
DHTMLSuite.JSDragDropTree.prototype = {
  init: function () {
    const ind = this.objectIndex
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS)
    JSTreeObj = this
    this.__createDropIndicator()
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk()
      }
    }
    document.documentElement.ondragstart =
      document.documentElement.ondragstart = function () {
        return false
      }
    DHTMLSuite.commonObj.__addEventEl(document.documentElement)
    let nodeId = 0
    const DHTMLSuite_tree = document.getElementById(this.idOfTree)
    const menuItems = DHTMLSuite_tree.getElementsByTagName('LI')
    for (var no = 0; no < menuItems.length; no++) {
      let noChildren = false
      var tmpVar = menuItems[no].getAttribute('noChildren')
      if (!tmpVar) tmpVar = menuItems[no].noChildren
      if (tmpVar == 'true') noChildren = true
      let noDrag = false
      var tmpVar = menuItems[no].getAttribute('noDrag')
      if (!tmpVar) tmpVar = menuItems[no].noDrag
      if (tmpVar == 'true') noDrag = true
      nodeId++
      const subItems = menuItems[no].getElementsByTagName('UL')
      const img = document.createElement('IMG')
      img.src =
        DHTMLSuite.configObj.imagePath + 'drag-drop-tree/' + this.plusImage
      img.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].showHideNode(e)
      }
      DHTMLSuite.commonObj.__addEventEl(img)
      if (subItems.length == 0) img.style.visibility = 'hidden'
      else {
        subItems[0].id = 'tree_ul_' + treeUlCounter
        treeUlCounter++
      }
      const aTag = menuItems[no].getElementsByTagName('A')[0]
      if (!noDrag) aTag.onmousedown = this.__initializeDragProcess
      if (!noChildren) {
        aTag.onmousemove = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragableNodes(
            e,
            'text'
          )
        }
        DHTMLSuite.commonObj.__addEventEl(aTag)
      }
      DHTMLSuite.commonObj.__addEventEl(aTag)
      menuItems[no].insertBefore(img, aTag)
      const folderImg = document.createElement('IMG')
      if (!noDrag) folderImg.onmousedown = this.__initializeDragProcess
      if (!noChildren) {
        folderImg.onmousemove = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragableNodes(
            e,
            'folder'
          )
        }
        DHTMLSuite.commonObj.__addEventEl(folderImg)
      }
      if (menuItems[no].className) {
        folderImg.src =
          DHTMLSuite.configObj.imagePath +
          'drag-drop-tree/' +
          menuItems[no].className
      } else {
        folderImg.src =
          DHTMLSuite.configObj.imagePath + 'drag-drop-tree/' + this.folderImage
      }
      DHTMLSuite.commonObj.__addEventEl(folderImg)
      menuItems[no].insertBefore(folderImg, aTag)
    }
    initExpandedNodes = DHTMLSuite.commonObj.getCookie(this.cookieName)
    if (initExpandedNodes) {
      const nodes = initExpandedNodes.split(',')
      for (var no = 0; no < nodes.length; no++) {
        if (nodes[no]) this.showHideNode(false, nodes[no])
      }
    }
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      'mousemove',
      DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]
        .__moveDragableNodes
    )
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      'mouseup',
      DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]
        .__dropDragableNodes
    )
  },
  setCookieName: function (cookieName) {
    this.cookieName = cookieName
  },
  setLayoutCss: function (cssFileName) {
    this.layoutCSS = cssFileName
  },
  setFolderImage: function (newFolderImage) {
    this.folderImage = newFolderImage
  },
  setPlusImage: function (newPlusImage) {
    this.plusImage = newPlusImage
  },
  setMinusImage: function (newMinusImage) {
    this.minusImage = newMinusImage
  },
  setMaximumDepth: function (maxDepth) {
    this.maximumDepth = maxDepth
  },
  setMessageMaximumDepthReached: function (newMessage) {
    this.messageMaximumDepthReached = newMessage
  },
  setTreeId: function (idOfTree) {
    this.idOfTree = idOfTree
  },
  expandAll: function () {
    const menuItems = document
      .getElementById(this.idOfTree)
      .getElementsByTagName('LI')
    for (let no = 0; no < menuItems.length; no++) {
      const subItems = menuItems[no].getElementsByTagName('UL')
      if (subItems.length > 0 && subItems[0].style.display != 'block') {
        this.showHideNode(false, menuItems[no].id)
      }
    }
  },
  collapseAll: function () {
    const menuItems = document
      .getElementById(this.idOfTree)
      .getElementsByTagName('LI')
    for (let no = 0; no < menuItems.length; no++) {
      const subItems = menuItems[no].getElementsByTagName('UL')
      if (subItems.length > 0 && subItems[0].style.display == 'block') {
        this.showHideNode(false, menuItems[no].id)
      }
    }
  },
  showHideNode: function (e, inputId) {
    if (inputId) {
      if (!document.getElementById(inputId)) return
      thisNode = document
        .getElementById(inputId)
        .getElementsByTagName('IMG')[0]
    } else {
      if (document.all) e = event
      const srcEl = DHTMLSuite.commonObj.getSrcElement(e)
      thisNode = srcEl
      if (srcEl.tagName == 'A') {
        thisNode = srcEl.parentNode.getElementsByTagName('IMG')[0]
      }
    }
    if (thisNode.style.visibility == 'hidden') return
    const parentNode = thisNode.parentNode
    inputId = parentNode.id.replace(/[^0-9]/g, '')
    if (thisNode.src.indexOf(this.plusImage) >= 0) {
      thisNode.src = thisNode.src.replace(this.plusImage, this.minusImage)
      const ul = parentNode.getElementsByTagName('UL')[0]
      ul.style.display = 'block'
      if (!initExpandedNodes) initExpandedNodes = ','
      if (initExpandedNodes.indexOf(',' + inputId + ',') < 0) {
        initExpandedNodes = initExpandedNodes + inputId + ','
      }
    } else {
      thisNode.src = thisNode.src.replace(this.minusImage, this.plusImage)
      parentNode.getElementsByTagName('UL')[0].style.display = 'none'
      initExpandedNodes = initExpandedNodes.replace(',' + inputId, '')
    }
    DHTMLSuite.commonObj.setCookie(this.cookieName, initExpandedNodes, 500)
    return false
  },
  getSaveString: function (initObj, saveString) {
    if (!saveString) var saveString = ''
    if (!initObj) {
      initObj = document.getElementById(this.idOfTree)
    }
    const lis = initObj.getElementsByTagName('LI')
    if (lis.length > 0) {
      let li = lis[0]
      while (li) {
        if (li.id) {
          if (saveString.length > 0) saveString = saveString + ','
          saveString = saveString + li.id.replace(/[^0-9]/gi, '')
          saveString = saveString + '-'
          saveString =
            li.parentNode.id != this.idOfTree
              ? saveString + li.parentNode.parentNode.id.replace(/[^0-9]/gi, '')
              : saveString + '0'
          const ul = li.getElementsByTagName('UL')
          if (ul.length > 0) {
            saveString = this.getSaveString(ul[0], saveString)
          }
        }
        li = li.nextSibling
      }
    }
    if (initObj.id == this.idOfTree) {
      return saveString
    }
    return saveString
  },
  __initializeDragProcess: function (e) {
    if (document.all) e = event
    const subs = JSTreeObj.floatingContainer.getElementsByTagName('LI')
    if (subs.length > 0) {
      if (JSTreeObj.dragNode_sourceNextSib) {
        JSTreeObj.dragNode_parent.insertBefore(
          JSTreeObj.dragNode_source,
          JSTreeObj.dragNode_sourceNextSib
        )
      } else {
        JSTreeObj.dragNode_parent.appendChild(JSTreeObj.dragNode_source)
      }
    }
    JSTreeObj.dragNode_source = this.parentNode
    JSTreeObj.dragNode_parent = this.parentNode.parentNode
    JSTreeObj.dragNode_sourceNextSib = false
    if (JSTreeObj.dragNode_source.nextSibling) {
      JSTreeObj.dragNode_sourceNextSib = JSTreeObj.dragNode_source.nextSibling
    }
    JSTreeObj.dragNode_destination = false
    JSTreeObj.dragDropTimer = 0
    DHTMLSuite.commonObj.__setTextSelOk(false)
    JSTreeObj.__waitBeforeDragProcessStarts()
    return false
  },
  __waitBeforeDragProcessStarts: function () {
    if (this.dragDropTimer >= 0 && this.dragDropTimer < 10) {
      this.dragDropTimer = this.dragDropTimer + 1
      setTimeout('JSTreeObj.__waitBeforeDragProcessStarts()', 20)
      return
    }
    if (this.dragDropTimer == 10) {
      JSTreeObj.floatingContainer.style.display = 'block'
      JSTreeObj.floatingContainer.appendChild(JSTreeObj.dragNode_source)
    }
  },
  __moveDragableNodes: function (e, tagType) {
    if (JSTreeObj.dragDropTimer < 10) return
    if (document.all) e = event
    dragDrop_x = e.clientX / 1 + 5 + document.body.scrollLeft
    dragDrop_y = e.clientY / 1 + 5 + document.documentElement.scrollTop
    JSTreeObj.floatingContainer.style.left = dragDrop_x + 'px'
    JSTreeObj.floatingContainer.style.top = dragDrop_y + 'px'
    let thisObj = DHTMLSuite.commonObj.getSrcElement(e)
    const thisObjOrig = DHTMLSuite.commonObj.getSrcElement(e)
    if (thisObj.tagName == 'A' || thisObj.tagName == 'IMG') {
      thisObj = thisObj.parentNode
    }
    JSTreeObj.dragNode_noSiblings = false
    let tmpVar = thisObj.getAttribute('noSiblings')
    if (!tmpVar) tmpVar = thisObj.noSiblings
    if (tmpVar == 'true') JSTreeObj.dragNode_noSiblings = true
    if (thisObj && tagType) {
      JSTreeObj.dragNode_destination = thisObj
      const img = thisObj.getElementsByTagName('IMG')[1]
      const tmpObj = JSTreeObj.dropTargetIndicator
      tmpObj.style.display = 'block'
      let eventSourceObj = thisObjOrig
      if (JSTreeObj.dragNode_noSiblings && eventSourceObj.tagName == 'IMG') {
        eventSourceObj = eventSourceObj.nextSibling
      }
      const tmpImg = tmpObj.getElementsByTagName('IMG')[0]
      if (thisObjOrig.tagName == 'A' || JSTreeObj.dragNode_noSiblings) {
        tmpImg.src = tmpImg.src.replace('ind1', 'ind2')
        JSTreeObj.insertAsSub = true
        tmpObj.style.left =
          DHTMLSuite.commonObj.getLeftPos(eventSourceObj) +
          JSTreeObj.indicator_offsetX_sub +
          'px'
      } else {
        tmpImg.src = tmpImg.src.replace('ind2', 'ind1')
        JSTreeObj.insertAsSub = false
        tmpObj.style.left =
          DHTMLSuite.commonObj.getLeftPos(eventSourceObj) +
          JSTreeObj.indicator_offsetX +
          'px'
      }
      tmpObj.style.top =
        DHTMLSuite.commonObj.getTopPos(thisObj) +
        JSTreeObj.indicator_offsetY +
        'px'
    }
    return false
  },
  __dropDragableNodes: function () {
    if (JSTreeObj.dragDropTimer < 10) {
      JSTreeObj.dragDropTimer = -1
      DHTMLSuite.commonObj.__setTextSelOk(true)
      return
    }
    let showMessage = false
    if (JSTreeObj.dragNode_destination) {
      const countUp = JSTreeObj.__getDepthOfABranchInTheTree(
        JSTreeObj.dragNode_destination,
        'up'
      )
      const countDown = JSTreeObj.__getDepthOfABranchInTheTree(
        JSTreeObj.dragNode_source,
        'down'
      )
      const countLevels =
        countUp / 1 + countDown / 1 + (JSTreeObj.insertAsSub ? 1 : 0)
      if (countLevels > JSTreeObj.maximumDepth) {
        JSTreeObj.dragNode_destination = false
        showMessage = true
      }
    }
    if (JSTreeObj.dragNode_destination) {
      if (JSTreeObj.insertAsSub) {
        const uls = JSTreeObj.dragNode_destination.getElementsByTagName('UL')
        if (uls.length > 0) {
          ul = uls[0]
          ul.style.display = 'block'
          var lis = ul.getElementsByTagName('LI')
          if (lis.length > 0) {
            ul.insertBefore(JSTreeObj.dragNode_source, lis[0])
          } else {
            ul.appendChild(JSTreeObj.dragNode_source)
          }
        } else {
          var ul = document.createElement('UL')
          ul.style.display = 'block'
          JSTreeObj.dragNode_destination.appendChild(ul)
          ul.appendChild(JSTreeObj.dragNode_source)
        }
        var img = JSTreeObj.dragNode_destination.getElementsByTagName('IMG')[0]
        img.style.visibility = 'visible'
        img.src = img.src.replace(JSTreeObj.plusImage, JSTreeObj.minusImage)
      } else {
        if (JSTreeObj.dragNode_destination.nextSibling) {
          const nextSib = JSTreeObj.dragNode_destination.nextSibling
          nextSib.parentNode.insertBefore(JSTreeObj.dragNode_source, nextSib)
        } else {
          JSTreeObj.dragNode_destination.parentNode.appendChild(
            JSTreeObj.dragNode_source
          )
        }
      }
      const tmpObj = JSTreeObj.dragNode_parent
      var lis = tmpObj.getElementsByTagName('LI')
      if (lis.length == 0) {
        var img = tmpObj.parentNode.getElementsByTagName('IMG')[0]
        img.style.visibility = 'hidden'
        DHTMLSuite.discardElement(tmpObj)
      }
    } else {
      if (JSTreeObj.dragNode_sourceNextSib) {
        JSTreeObj.dragNode_parent.insertBefore(
          JSTreeObj.dragNode_source,
          JSTreeObj.dragNode_sourceNextSib
        )
      } else {
        JSTreeObj.dragNode_parent.appendChild(JSTreeObj.dragNode_source)
      }
    }
    JSTreeObj.dropTargetIndicator.style.display = 'none'
    JSTreeObj.dragDropTimer = -1
    DHTMLSuite.commonObj.__setTextSelOk(true)
    if (showMessage && JSTreeObj.messageMaximumDepthReached) {
      alert(JSTreeObj.messageMaximumDepthReached)
    }
  },
  __createDropIndicator: function () {
    this.dropTargetIndicator = document.createElement('DIV')
    this.dropTargetIndicator.style.zIndex = 240000
    this.dropTargetIndicator.style.position = 'absolute'
    this.dropTargetIndicator.style.display = 'none'
    const img = document.createElement('IMG')
    img.src =
      DHTMLSuite.configObj.imagePath + 'drag-drop-tree/' + 'dragDrop_ind1.gif'
    img.id = 'dragDropIndicatorImage'
    this.dropTargetIndicator.appendChild(img)
    document.body.appendChild(this.dropTargetIndicator)
  },
  __getDepthOfABranchInTheTree: function (obj, direction, stopAtObject) {
    let countLevels = 0
    if (direction == 'up') {
      while (obj.parentNode && obj.parentNode != stopAtObject) {
        obj = obj.parentNode
        if (obj.tagName == 'UL') countLevels = countLevels / 1 + 1
      }
      return countLevels
    }
    if (direction == 'down') {
      const subObjects = obj.getElementsByTagName('LI')
      for (let no = 0; no < subObjects.length; no++) {
        countLevels = Math.max(
          countLevels,
          JSTreeObj.__getDepthOfABranchInTheTree(subObjects[no], 'up', obj)
        )
      }
      return countLevels
    }
  }
}

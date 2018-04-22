
//so that several modals can be created dynamically with their own id's
var modal_count = 0;

function modal(content,//what you want to present to the user
               title=document.title,//title of the message box
               modal_id='modal-'+(modal_count++),//auto increments but can specify your own id
               bodyElement=null,//container for the content below the title
               titleElement=null,//the title bar at the top
               closeButtonElement=null,
               containerElement=null,//the dialogue box centering everything
               shadeElement=null //the absolute parent of the modal/ the background shade
) {

    function close_modal() {
        shadeElement.style.display = "none";
        //and now we need to destroy it coz a new one is created each time don't want a million modals.
        //note currently the modal clones the content so that it is not lost if an element in the page is specified
        document.body.removeChild(shadeElement);
    }

    //setup default elements if nothing is provided..
    //the modal/shaded background
    if (shadeElement==null){
        shadeElement = document.createElement('div');
        shadeElement.id=modal_id;
        shadeElement.className = 'modal-shade';
    }

    //the dialogue box
    if (containerElement==null){
        containerElement = document.createElement('div');
        containerElement.className = 'modal-container';
    }
    //the title bar
    if (titleElement==null){
        titleElement = document.createElement('div');
        titleElement.className = 'modal-title';
    }
    //the content body container
    if (bodyElement==null){
        bodyElement = document.createElement('div');
        bodyElement.className = 'modal-body';
    }

    //the close button
    if (closeButtonElement==null){
        closeButtonElement = document.createElement('div');
        closeButtonElement.className = 'modal-close';
        closeButtonElement.innerHTML+='&times;';
    }

    //construct the modal
    shadeElement.appendChild(containerElement);
    containerElement.appendChild(titleElement);
    titleElement.appendChild(closeButtonElement);
    containerElement.appendChild(bodyElement);

    /*todo: would be nice if the type is element to check if it has a parent element
    * and move it instead of cloning it.
    * then either move it back or remember the modal instead of destroying it.
    * Could have huge performance issues if cloning complicated dom tree for content.*/

    //detect type of title and add to body
    if (typeof title === 'string'){
        title = document.createTextNode(title);
    }
    titleElement.appendChild(title.cloneNode(true));

    //detect type of content and add to body
    if (typeof content === 'string'){
        console.log('we got a string');
        content = document.createTextNode(content);
    }
    bodyElement.appendChild(content.cloneNode(true));

    //add the modal to the page
    document.body.appendChild(shadeElement);

    // When the user clicks anywhere outside of the modal or the close button
    document.addEventListener('click',function () {
        if (event.target === shadeElement || event.target === closeButtonElement){
            close_modal();
        }
    });

    //finally show the modal
    shadeElement.style.display='block';
}
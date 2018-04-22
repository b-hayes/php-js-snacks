<?php
/**
 * Created by PhpStorm.
 * User: Brad
 * Date: 21/04/2018
 * Time: 7:14 PM
 */

/**
 * Generic/Dynamic modal script that I created for the sake of not having to recreate the html for common
 * modals over and over again.
 *
 * Can be used both with php or javascript
 *
 * For a minimalist approach I avoided the use of jquery and provided both a way to create
 * modals dynamically in php and in javascript.
 *
 * To start with I used w3schools example: https://www.w3schools.com/howto/howto_css_modals.asp
 * and added all my advancements from this minimalist example.
 *
 * Things I discovered because of doing this:
 *
 * window.onclick
 * Overrides any previous onclick handlers meaning w3chools exmaple sets you up to fail
 * with all window click functions being replaced by the modal close.
 * Additionally the window element is not supported in older browsers and is almost identical to
 * using document instead.
 *
 * use document instead of window.
 * use addEventListener instead of onclick.
 *
 * Side note addEventListener is also not handled by older internetExplorer browsers and require
 * the use of attachEvent instead.
 * A simple check for IE v<9 can be done with if (element.attachEvent) or with the use of jQuery However..
 * IE is dead and gone imo and I chose to ignore IE v.8 and below.
 *
 * An excellent explanation can be found here: https://stackoverflow.com/questions/6348494/addeventlistener-vs-onclick
 *
 * Why did I avoid using jquery?
 * We learned to just use jQuery functions at uni straight off the bat and I never "really" leaned javascript.
 * I found myself relying heavily on jquery in the past simply for $(selecting stuff) and doing some animations.
 * 1. With the new age of browsers finally coming together with standard javascript interpretations
 * there doesn't seem to be a need to rely on jquery for browser compatibly anymore.
 * 2. As much I like jQuery selector methods and functions I found myself spending just as much time
 * googleing to remember how to use jquery functions as I would learning to just write pure javascript.
 * 3. document.getElement.addEvent.style etc with auto-completion etc is easier/faster to type with intellisence
 * than $("body").on("click"...
 * 4. specific behaviours of event handling ect are more clear and directly controlled with pure javascript.
 * 5. Again with new browser all using css standard why use jquery animations when css3 animations are
 * automatically triggered when the element is visible and are far superior in terms of performance.
 * (jquery animations locked to 77fps and ccs3 using dynamic fps with hardware acceleration and browser can pre-
 * determine animation results ahead of time to load the display variations before they happen.)
 *
 * I will still use jquery for projects or for quick show/hide animations and doing ajax calls in prototypes
 * however, for building modular libraries like this to do simple ui tasks it's probably better practice not
 * to use lazy jQuery selector code that adds to the client side processing and memory usage.
 *(even cheap devices these days can handle the it but why accumulate overheads you don't need)
 *
 * Basically I just want to know how to do things more efficiently and I'll probably appreciate Jquery a lot more
 * afterwards and use it's features more appropriately when I fully understand what jquery is actually doing for me.
 */
?>
<head>
    <title>Modal Examples</title>
</head>
<style>
    /*just so the test buttons here look better*/
    button{
        width: 48%;
        min-height: 50px;
        margin-bottom: 1%;
        margin-right: 1%;
    }
    @media only screen and (max-width: 600px) {
        button{
            width: 100%;
        }
    }
</style>

<!--Manually created modal-->

<!--
Styles for the manually defined modal are just using my defaults I defined in modal.css.
The defaults are using the most basic display from w3schools example
but I added vertical & horizontal centering.
The important parts of css are:
 The shade being a fixed position so it covers the entire window regardless of where it is in the dom tree
 The shade having z position of 1 or higher to render on top of all the other elements.
 The child container element also need the parent to be fixed or absolute for the vertical centering to work.
 Vertical & horizontal centering of the child(modal-container) is optional and can be commented out of the css file.
 -->
<link rel="stylesheet" href="modals.css">


<h1>Generic/Dynamic modals. Usage Examples</h1>
<p>Does not require jquery</p>

<!-- BELOW IS MODAL DEFINED MANUALLY -->

<!-- Trigger/Open The Modal -->
<button id="myModal-open">Open Modal that was defined manually</button>

<!-- The Modal -->
<div id="myModal" class="modal-shade">
    <p style="color: white; background: black"> This dark area is the modal-shade.</p>
    <!-- Modal container -->
    <div class="modal-container" style="background: #595959">
        <div class="modal-title">This is the title bar
            <div id="myModal-close" class="modal-close">&times;</div>
        </div>
        <div class="modal-body">
            <p>This is the modal body.</p>
        </div>
        <p>This is the modal container. positioned center stage!</p>
    </div>
</div>

<script>
    /**
     * javascript manually defined for the manually created modal
     * this is to show the initial process of creating the modal layout & behaviour that is
     * used in the function later.
     */

    //This event handler isn't needed for the modal. Just an example to show the syntax of adding event handlers.
    document.addEventListener(
        'click',//type of event
        function (event) {//what to do on this event
            console.log(event.target);
        },
        false //default is false: inner most element clicked fires the event first, true: outermost parent fires first
    );

    // Get the modal (for the purpose of having a modal function defined I called this shade)
    var shade = document.getElementById('myModal');

    // Get the button that opens the modal
    var open = document.getElementById("myModal-open");

    // Get the element that closes the modal
    var close = document.getElementById("myModal-close");

    // When the user clicks anywhere outside of the modal(on the shade), hide the modal
    document.addEventListener('click',function () {
        if (event.target == shade) shade.style.display = "none";
    });
    // When the user clicks the close button hide the modal
    document.addEventListener('click',function () {
        if (event.target == close) shade.style.display = "none";
    });

    // When the user clicks open button
    document.addEventListener('click',function (event) {
        if (event.target == open) shade.style.display = "block";
    });
</script>

<!--Modal created by my javascript function-->
<script src="modal.js"></script>
<button onclick="modal('This modal was created with the modal() function');">
    Open modal created dynamically with javascript function</button>

<!-- infinite modals -->
<button onclick="modal(this);">Infinite modals. Passing this button as the content. Witch is cloned by the modal.</button>

<script>
    function someText() {
        return "some text from a function";
    }
</script>
<!--Using the result of a function as the modal content-->
<button onclick="modal(someText());">Display the result of a function in the modal.</button>

"use strict";
const start_canvas = () => {
    //setup global variables
    window.__INITIAL_DATA__ = {
        "canvas_w": 600,
        "canvas_h": 400
    };
    //set values of globals
    const initialData = window.__INITIAL_DATA__;
    const canvas_h = initialData.canvas_h;
    const canvas_w = initialData.canvas_w;
    //load canvas and setup
    var canvas = document.getElementById("pc_canvas");
    //so it doesn't throw an error when this element is null
    if (canvas) {
        var ctx = canvas.getContext('2d');
        ctx.canvas.width = canvas_w;
        ctx.canvas.height = canvas_h;
        load_images(ctx);
        ctx.fillStyle = '#CCFF55';
    }
    //load images to and image array
    //game loop
    //setup canvas buffer
    //draw images into canvas
    //map or grid
    //
};

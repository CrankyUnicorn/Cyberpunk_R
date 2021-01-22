"use strict";
const load_images = (ctx) => {
    const loadImagePath = [
        'assets/tiles/sea_tile.png',
        'assets/tiles/boat_tile.png',
        'assets/tiles/monster_tile.png'
    ];
    const imageArray = [];
    for (let index = 0; index < loadImagePath.length; index++) {
        const _image = new Image(100, 100);
        _image.src = loadImagePath[index];
        imageArray.push(_image);
    }
    window.onload = () => draw_grids(ctx, imageArray);
};

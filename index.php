<?php
/**
 * Author : Salim Nazir
 * Email : salnazi@gmail.com
 * Powered By : JA Square
 * Module : JA Square Marketplace
 * FILENAME : index.php
 * Path : /business-card/index.php
 * Updated : 2026-01-12 11:05:00 (Asia/Kolkata +5:30)
 * Version : 1.7.0
 * Status : Active
 * Logic : Full Creative Suite with Outline Thickness Control, PNG Export, and Multi-Source Images.
 */
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Card Pro | JA Square</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&family=Montserrat:wght@500;800&family=Pacifico&family=Oswald:wght@500&family=Lobster&family=Bebas+Neue&family=Abril+Fatface&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <style>
        :root { --md-sys-color-primary: #6750A4; --glass-bg: rgba(255, 255, 255, 0.45); }
        * { box-sizing: border-box; }
        body, html { margin: 0; padding: 0; height: 100vh; font-family: 'Roboto', sans-serif; background: #ebedee; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        
        .main-container { width: 96vw; height: 90vh; display: flex; background: var(--glass-bg); backdrop-filter: blur(25px); border-radius: 32px; border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 12px 40px rgba(0,0,0,0.1); overflow: hidden; }
        .side { flex: 1; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; }
        .editor-side { overflow-y: auto; justify-content: flex-start; padding-top: 30px; scrollbar-width: none; }
        .editor-side::-webkit-scrollbar { display: none; }
        .preview-side { background-color: #f8f9fa; border-left: 1px solid rgba(0,0,0,0.05); }

        .control-panel { width: 100%; max-width: 280px; display: flex; flex-direction: column; gap: 10px; }
        .control-group { background: white; padding: 14px; border-radius: 16px; border: 1px solid #ddd; }
        .control-label { font-size: 10px; font-weight: 700; color: #6750A4; text-transform: uppercase; margin-bottom: 8px; display: block; }

        .m3-input { width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #79747E; font-size: 13px; outline: none; margin-bottom: 8px; }
        .m3-btn { width: 100%; padding: 12px; background: white; border: 1px solid #79747E; border-radius: 12px; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 13px; transition: all 0.2s; }
        .m3-btn:hover { background: #f0f0f0; }

        select, input[type="color"] { width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; font-family: 'Roboto'; font-size: 13px; }
        input[type="range"] { width: 100%; accent-color: var(--md-sys-color-primary); margin-top: 5px; }
        
        .canvas-container { box-shadow: 0 20px 50px rgba(0,0,0,0.15); border-radius: 12px; overflow: hidden; background: white; }
        .layer-tools { display: flex; gap: 5px; margin-top: 8px; }
        .tool-btn { flex: 1; padding: 10px; background: #f0f0f0; border: none; border-radius: 8px; cursor: pointer; font-size: 10px; font-weight: 600; text-transform: uppercase; }

        @media print { body * { visibility: hidden; } .canvas-container, .canvas-container * { visibility: visible; } .canvas-container { position: absolute; left: 0; top: 0; box-shadow: none; } }
    </style>
</head>
<body>

<div class="main-container">
    <div class="side editor-side">
        <h2 style="margin-bottom: 20px; font-weight: 500;">Creative Suite</h2>
        <div class="control-panel">
            
            <div class="control-group">
                <span class="control-label">Images (URL & Manual)</span>
                <input type="text" id="url-input" class="m3-input" placeholder="Paste image URL...">
                <div class="layer-tools">
                    <button class="tool-btn" onclick="loadAsset('url', 'bg')">Set BG</button>
                    <button class="tool-btn" onclick="loadAsset('url', 'logo')">Add Logo</button>
                </div>
                <input type="file" id="file-input" hidden accept="image/*" onchange="loadAsset('file', 'logo')">
                <button class="m3-btn" style="margin-top:8px;" onclick="document.getElementById('file-input').click()">
                    <i class="material-icons-outlined">upload</i> Local Upload
                </button>
            </div>

            <div class="control-group">
                <span class="control-label">Text & Style</span>
                <input type="text" id="text-input" class="m3-input" placeholder="Enter text...">
                <select id="font-family" class="m3-input" onchange="updateProp('fontFamily', this.value)">
                    <option value="Roboto">Roboto</option>
                    <option value="Bebas Neue">Bebas Neue</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Pacifico">Pacifico</option>
                    <option value="Playfair Display">Playfair</option>
                    <option value="Lobster">Lobster</option>
                </select>
                
                <div style="display:flex; gap:8px; margin-bottom:10px;">
                    <div style="flex:1">
                        <span class="control-label" style="font-size:8px;">Fill Color</span>
                        <input type="color" id="text-color" value="#1C1B1F" onchange="updateProp('fill', this.value)">
                    </div>
                    <div style="flex:1">
                        <span class="control-label" style="font-size:8px;">Outline Color</span>
                        <input type="color" id="stroke-color" value="#000000" onchange="updateProp('stroke', this.value)">
                    </div>
                </div>

                <span class="control-label" style="font-size:8px;">Outline Thickness</span>
                <input type="range" id="outline-size" min="0" max="10" step="0.5" value="0" oninput="updateProp('strokeWidth', parseFloat(this.value))">

                <button class="m3-btn" style="margin-top:10px;" onclick="addText()">
                    <i class="material-icons-outlined">add_circle</i> Add Text Layer
                </button>
            </div>

            <div class="control-group">
                <span class="control-label">Layers & Filters</span>
                <div class="layer-tools">
                    <button class="tool-btn" onclick="order('front')">Front</button>
                    <button class="tool-btn" onclick="order('back')">Back</button>
                </div>
                <span class="control-label" style="font-size:8px; margin-top:10px;">Opacity</span>
                <input type="range" id="op-slider" min="0" max="1" step="0.1" value="1" oninput="filters('opacity', this.value)">
                <span class="control-label" style="font-size:8px;">Gaussian Blur</span>
                <input type="range" id="blur-slider" min="0" max="1" step="0.1" value="0" oninput="filters('blur', this.value)">
            </div>

            <button class="m3-btn" style="color:#B3261E; border-color:#F9DEDC;" onclick="canvas.remove(canvas.getActiveObject())">
                <i class="material-icons-outlined">delete_sweep</i> Remove Selected
            </button>
        </div>
    </div>

    <div class="side preview-side">
        <div class="canvas-container">
            <canvas id="c" width="500" height="285"></canvas>
        </div>
        
        <div style="margin-top: 25px; display:flex; gap:10px; justify-content:center;">
            <button class="m3-btn" style="width:auto; padding:12px 25px;" onclick="downloadPNG()">
                <i class="material-icons-outlined">file_download</i> PNG
            </button>
            <button class="m3-btn" style="width:auto; padding:12px 25px; background:var(--md-sys-color-primary); color:white; border:none;" onclick="saveAndPrint()">
                <i class="material-icons-outlined">print</i> PRINT
            </button>
        </div>
    </div>
</div>

<script>
    const canvas = new fabric.Canvas('c', { preserveObjectStacking: true });

    function loadAsset(source, type) {
        if (source === 'url') {
            const url = document.getElementById('url-input').value;
            if (!url) return;
            fabric.Image.fromURL(url, (img) => processImg(img, type), { crossOrigin: 'anonymous' });
            document.getElementById('url-input').value = "";
        } else {
            const reader = new FileReader();
            reader.onload = (f) => fabric.Image.fromURL(f.target.result, (img) => processImg(img, type));
            reader.readAsDataURL(document.getElementById('file-input').files[0]);
        }
    }

    function processImg(img, type) {
        if (type === 'bg') {
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                scaleX: canvas.width / img.width, scaleY: canvas.height / img.height, crossOrigin: 'anonymous'
            });
        } else {
            img.scaleToWidth(150);
            canvas.add(img);
            canvas.centerObject(img);
            canvas.setActiveObject(img);
        }
    }

    function addText() {
        const val = document.getElementById('text-input').value || "Sample Text";
        const t = new fabric.IText(val, { 
            left: 50, top: 50, fontFamily: 'Roboto', fontSize: 24, 
            fill: document.getElementById('text-color').value,
            stroke: document.getElementById('stroke-color').value,
            strokeWidth: parseFloat(document.getElementById('outline-size').value)
        });
        canvas.add(t);
        canvas.setActiveObject(t);
        document.getElementById('text-input').value = "";
    }

    function updateProp(prop, value) {
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.set(prop, value);
            canvas.renderAll();
        }
    }

    function order(dir) {
        const obj = canvas.getActiveObject();
        if (!obj) return;
        dir === 'front' ? obj.bringToFront() : (obj.sendToBack(), canvas.backgroundImage && obj.bringForward());
        canvas.renderAll();
    }

    function filters(type, val) {
        const target = canvas.getActiveObject() || canvas.backgroundImage;
        if (!target) return;
        if (type === 'opacity') target.set('opacity', parseFloat(val));
        if (type === 'blur' && target.type === 'image') {
            target.filters = [new fabric.Image.filters.Blur({ blur: parseFloat(val) })];
            target.applyFilters();
        }
        canvas.renderAll();
    }

    function downloadPNG() {
        const dataURL = canvas.toDataURL({ format: 'png', quality: 1.0 });
        const link = document.createElement('a');
        link.download = 'JA-Square-' + Date.now() + '.png';
        link.href = dataURL;
        link.click();
    }

    async function saveAndPrint() {
        const json = JSON.stringify(canvas.toJSON());
        const formData = new FormData();
        formData.append('full_name', 'Design ' + Date.now());
        formData.append('canvas_json', json);
        await fetch('save_card.php', { method: 'POST', body: formData });
        window.print();
    }
</script>
</body>
</html>
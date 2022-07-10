@extends('Layout.master')
@section('content')
    <section class="content" id="app">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Create Theme</h2>
            </div>

            <div class="theme-container">

                <div class="theme-settings">

                    <div class="each-grp">
                       <div class="each-header">
                           <div class="p">Background Settings</div>
                           <div @click="()=> openSettings.background = !openSettings.background">
                                @{{openSettings.background ? 'Close' : 'Open'}}
                           </div>
                       </div>

                       <div v-if="openSettings.background">
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Background Color</div>
                                <input type="color" style="float:right;" ref="backBackColor"
                                @change="setColor('background', 'backgroundColor', 'backBackColor')" v-model="styles.background.backgroundColor" />                           
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Border Edge</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('background', 'borderRadius', 'round')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.background.borderRadius == 'round'"/>
                                        <label class="form-check-label">Round</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('background', 'borderRadius', 'squared')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.background.borderRadius == 'squared'"
                                        />
                                        <label class="form-check-label">Squared</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Border</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('background', 'border', true)">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.background.border">
                                        <label class="form-check-label">On</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('background', 'border', false)">
                                        <input class="form-check-input" type="radio"
                                        :checked="!styles.background.border">
                                        <label class="form-check-label">Off</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings" v-if="styles.background.border">
                                <div class="settings-label" style="display:inline;">Set Border Width</div>
                                <select class="form-select" v-model="styles.background.borderWidth">
                                    <option value="1px">1px</option>
                                    <option value="2px">2px</option>
                                    <option value="3px">3px</option>
                                    <option value="4px">4px</option>
                                    <option value="5px">5px</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings" v-if="styles.background.border">
                                <div class="settings-label" style="display:inline;">Set Border Style</div>
                                <select class="form-select" v-model="styles.background.borderStyle">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="insert">Inset</option>
                                    <option value="outsert">Outset</option>
                                    <option value="groove">Groove</option>
                                    <option value="double">Double</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings" v-if="styles.background.border">
                                <div class="settings-label" style="display:inline;">Set Border Color</div>
                                <input type="color" style="float:right;" ref="backborderColor" 
                                v-model="styles.background.borderColor"
                                @change="setColor('background', 'borderColor', 'backborderColor')"/>                           
                            </div>
                       </div>
                    </div>

                    <div class="each-grp">
                       <div class="each-header">
                           <div class="p">Description Settings</div>
                           <div @click="()=> openSettings.description = !openSettings.description">
                                <span>@{{openSettings.description ? 'Close' : 'Open'}}</span>
                           </div>
                       </div>

                        <div class="each-line-settings" v-if="openSettings.description">
                            <div class="settings-label" style="display:inline;">Set Color</div>
                            <input type="color" style="float:right;" ref="descriptionColor" 
                            v-model="styles.description.color"
                            @change="setColor('description', 'color', 'descriptionColor')"/>                          
                        </div>
                        
                    </div>

                    <div class="each-grp">
                       <div class="each-header">
                           <div class="p">Media Settings</div>
                           <div @click="()=> openSettings.media = !openSettings.media">
                                <span>@{{openSettings.media ? 'Close' : 'Open'}}</span>
                           </div>
                       </div>

                        <div class="each-line-settings" v-if="openSettings.media">
                            <div class="settings-label" style="display:inline;">Border Edge</div>

                            <div style="display:flex;"> 
                                <div class="form-check form-check-inline"
                                @click="setRadio('media', 'borderRadius', 'round')">
                                    <input class="form-check-input" type="radio"
                                    :checked="styles.media.borderRadius == 'round'">
                                    <label class="form-check-label">Round</label>
                                </div>
                                <div class="form-check form-check-inline"
                                @click="setRadio('media', 'borderRadius', 'squared')">
                                    <input class="form-check-input" type="radio"
                                    :checked="styles.media.borderRadius == 'squared'">
                                    <label class="form-check-label">Squared</label>
                                </div>                                
                            </div>
                      
                        </div>
                   </div>

                    <div class="each-grp">
                        <div class="each-header">
                            <div class="p">Input Field Settings</div>
                            <div @click="()=> openSettings.input = !openSettings.input">
                                    <span>@{{openSettings.input ? 'Close' : 'Open'}}</span>
                            </div>
                        </div>

                       <div v-if="openSettings.input">
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Edge</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('input', 'borderRadius', 'round')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.input.borderRadius == 'round'">
                                        <label class="form-check-label">Round</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('input', 'borderRadius', 'squared')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.input.borderRadius == 'squared'">
                                        <label class="form-check-label">Squared</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Background Color</div>
                                <input type="color" style="float:right;" ref="inputBackColor" 
                                v-model="styles.input.backgroundColor"
                                @change="setColor('input', 'backgroundColor', 'inputBackColor')"/>                         
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Font Color</div>
                                <input type="color" style="float:right;" ref="inputColor" 
                                v-model="styles.input.color"
                                @change="setColor('input', 'color', 'inputColor')"/>                       
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Placeholder Color</div>
                                <input type="color" style="float:right;" ref="placeholdercolor" 
                                v-model="styles.input.placeholderColor"
                                @change="setColor('input', 'placeholderColor', 'placeholdercolor')"/>                           
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Border</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('input', 'border', true)">
                                        <input class="form-check-input" type="radio" 
                                        :checked="styles.input.border"/>
                                        <label class="form-check-label">On</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('input', 'border', false)">
                                        <input class="form-check-input" type="radio" 
                                        :checked="!styles.input.border"/>
                                        <label class="form-check-label">Off</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Width</div>
                                <select class="form-select" v-model="styles.input.borderWidth">
                                    <option value="1px">1px</option>
                                    <option value="2px">2px</option>
                                    <option value="3px">3px</option>
                                    <option value="4px">4px</option>
                                    <option value="5px">5px</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Style</div>
                                <select class="form-select" v-model="styles.input.borderStyle">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="insert">Inset</option>
                                    <option value="outsert">Outset</option>
                                    <option value="groove">Groove</option>
                                    <option value="double">Double</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Color</div>
                                <input type="color" style="float:right;" ref="inputbordercolor" 
                                v-model="styles.input.borderColor"
                                @change="setColor('input', 'borderColor', 'inputbordercolor')"/>                          
                            </div>                             
                       </div>
                    </div>

                   <div class="each-grp">
                       <div class="each-header">
                           <div class="p">Question Settings</div>
                           <div @click="()=> openSettings.question = !openSettings.question">
                                <span>@{{openSettings.question ? 'Close' : 'Open'}}</span>
                           </div>
                       </div>

                       <div v-if="openSettings.question">
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Edge</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('question', 'borderRadius', 'round')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.question.borderRadius == 'round'">
                                        <label class="form-check-label">Round</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('question', 'borderRadius', 'squared')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.question.borderRadius == 'squared'">
                                        <label class="form-check-label">Squared</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Background Color</div>
                                <input type="color" style="float:right;" ref="questionbackcolor" 
                                v-model="styles.question.backgroundColor"
                                @change="setColor('question', 'backgroundColor', 'questionbackcolor')"/>                         
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Font Color</div>
                                <input type="color" style="float:right;" ref="questioncolor" 
                                v-model="styles.question.color"
                                @change="setColor('question', 'color', 'questioncolor')"/>                         
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Border</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('question', 'border', true)">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.question.border">
                                        <label class="form-check-label">On</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('question', 'border', false)">
                                        <input class="form-check-input" type="radio"
                                        :checked="!styles.question.border">
                                        <label class="form-check-label">Off</label>
                                    </div>                                
                                </div>
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Width</div>
                                <select class="form-select" v-model="styles.question.borderWidth">
                                    <option value="1px">1px</option>
                                    <option value="2px">2px</option>
                                    <option value="3px">3px</option>
                                    <option value="4px">4px</option>
                                    <option value="5px">5px</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Style</div>
                                <select class="form-select" v-model="styles.question.borderStyle">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="insert">Inset</option>
                                    <option value="outsert">Outset</option>
                                    <option value="groove">Groove</option>
                                    <option value="double">Double</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Color</div>
                                <input type="color" style="float:right;" ref="questionbordercolor" 
                                v-model="styles.question.borderColor"
                                @change="setColor('question', 'borderColor', 'questionbordercolor')"/>                          
                            </div>                           
                       </div> 
                   </div>

                   <div class="each-grp">
                       <div class="each-header">
                           <div class="p">Submit Button Settings</div>
                           <div @click="()=> openSettings.button = !openSettings.button">
                                <span>@{{openSettings.button ? 'Close' : 'Open'}}</span>
                           </div>
                       </div>

                       <div v-if="openSettings.button">
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Edge</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('button', 'borderRadius', 'round')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.button.borderRadius == 'round'">
                                        <label class="form-check-label">Round</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('button', 'borderRadius', 'squared')">
                                        <input class="form-check-input" type="radio" 
                                        :checked="styles.button.borderRadius == 'squared'">
                                        <label class="form-check-label">Squared</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Background Color</div>
                                <input type="color" style="float:right;" ref="buttonbackcolor" 
                                v-model="styles.button.backgroundColor"
                                @change="setColor('button', 'backgroundColor', 'buttonbackcolor')"/>                            
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Font Color</div>
                                <input type="color" style="float:right;" ref="buttoncolor" 
                                v-model="styles.button.color"
                                @change="setColor('button', 'color', 'buttoncolor')"/>                            
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Border</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('button', 'border', true)">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.button.border">
                                        <label class="form-check-label">On</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('button', 'border', false)">
                                        <input class="form-check-input" type="radio"
                                        :checked="!styles.button.border">
                                        <label class="form-check-label">Off</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Width</div>
                                <select class="form-select" v-model="styles.button.borderWidth">
                                    <option value="1px">1px</option>
                                    <option value="2px">2px</option>
                                    <option value="3px">3px</option>
                                    <option value="4px">4px</option>
                                    <option value="5px">5px</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Style</div>
                                <select class="form-select" v-model="styles.button.borderWidth">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="insert">Inset</option>
                                    <option value="outsert">Outset</option>
                                    <option value="groove">Groove</option>
                                    <option value="double">Double</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Color</div>
                                <input type="color" style="float:right;" ref="buttonbordercolor" 
                                v-model="styles.button.borderColor"
                                @change="setColor('button', 'borderColor', 'buttonbordercolor')"/>                         
                            </div>                           
                       </div>
                   </div>

                   <div class="each-grp">
                        <div class="each-header">
                            <div class="p">Skip Button Settings</div>
                            <div @click="()=> openSettings.skip = !openSettings.skip">
                                    <span>@{{openSettings.skip ? 'Close' : 'Open'}}</span>
                            </div>
                        </div>

                        <div v-if="openSettings.skip">
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Edge</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('skip', 'borderRadius', 'round')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.skip.borderRadius == 'round'">
                                        <label class="form-check-label">Round</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('skip', 'borderRadius', 'squared')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.skip.borderRadius == 'squared'">
                                        <label class="form-check-label">Squared</label>
                                    </div>                                
                                </div>
                            </div> 

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Border</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('skip', 'border', true)">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.skip.border">
                                        <label class="form-check-label">On</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('skip', 'border', false)">
                                        <input class="form-check-input" type="radio"
                                        :checked="!styles.skip.border">
                                        <label class="form-check-label">Off</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Width</div>
                                <select class="form-select" v-model="styles.skip.borderWidth">
                                    <option value="1px">1px</option>
                                    <option value="2px">2px</option>
                                    <option value="3px">3px</option>
                                    <option value="4px">4px</option>
                                    <option value="5px">5px</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Style</div>
                                <select class="form-select"  v-model="styles.skip.borderStyle">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="insert">Inset</option>
                                    <option value="outsert">Outset</option>
                                    <option value="groove">Groove</option>
                                    <option value="double">Double</option>
                                </select>                                                    
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Border Color</div>
                                <input type="color" style="float:right;" ref="skipbordercolor" 
                                v-model="styles.skip.borderColor"
                                @change="setColor('skip', 'borderColor', 'skipbordercolor')"/>                         
                            </div>
                        
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Background Color</div>
                                <input type="color" style="float:right;" ref="skipbackcolor" 
                                v-model="styles.skip.backgroundColor"
                                @change="setColor('skip', 'backgroundColor', 'skipbackcolor')"/>                           
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Font Color</div>
                                <input type="color" style="float:right;" ref="skipcolor" 
                                v-model="styles.skip.color"
                                @change="setColor('skip', 'color', 'skipcolor')"/>                           
                            </div>
                        </div>
                   </div> 

                   <div class="each-grp">
                       <div class="each-header">
                           <div class="p">Timer Settings</div>
                           <div @click="()=> openSettings.timer = !openSettings.timer">
                                <span>@{{openSettings.timer ? 'Close' : 'Open'}}</span>
                           </div>
                       </div>

                       <div v-if="openSettings.timer">
                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Position</div>

                                <div style="display:flex;"> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('timer', 'position', 'left')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.timer.position == 'left'">
                                        <label class="form-check-label">Left</label>
                                    </div>
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('timer', 'position', 'center')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.timer.position == 'center'">
                                        <label class="form-check-label">Center</label>
                                    </div> 
                                    <div class="form-check form-check-inline"
                                    @click="setRadio('timer', 'position', 'right')">
                                        <input class="form-check-input" type="radio"
                                        :checked="styles.timer.position == 'right'">
                                        <label class="form-check-label">Right</label>
                                    </div>                                
                                </div>
                        
                            </div>

                            <div class="each-line-settings">
                                <div class="settings-label" style="display:inline;">Set Font Color</div>
                                <input type="color" style="float:right;" ref="timercolor" 
                                v-model="styles.timer.color"
                                @change="setColor('timer', 'color', 'timercolor')"/>                         
                            </div>                           
                       </div>


                   </div>

                   <div class="each-line-settings">
                        <input type="text" placeholder="Enter theme name" 
                        style="width:100%;padding: 1rem;border-radius: 5px;
                        border:none;font-family:'Poppins';margin-bottom:2rem;" v-model="name"/>
                    </div>

                    <div class="alert alert-danger" role="alert" v-if="error">
                        Theme Name is required
                    </div>

                    <div style="display:flex;justify-content:space-between;margin-top:3rem;">
                        <button style="width:48%;" type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#exampleModal">Preview</button>

                        <button style="width:48%;" type="button" class="btn btn-success" v-if="!edit"
                        @click="saveTheme">Save</button>

                        <button style="width:48%;" type="button" class="btn btn-success" v-if="edit"
                        @click="updateTheme">Update</button>
                    </div>

                </div>

                <div class="right-content">
                    <div class="content" :style="{
                        backgroundColor: styles.background.backgroundColor,
                        borderRadius: styles.background.borderRadius 
                        == 'round' ? '10px' : '0',
                        border: styles.background.border ? `${styles.background.borderWidth} 
                        ${styles.background.borderStyle} ${styles.background.borderColor}` : 'none',
                    }">
                        <p :style="{
                            color: styles.description.color,
                        }">Description content goes here ...</p>

                        <div class="showpreimg"
                        :style="{
                            backgroundImage: 'url('+'https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg?auto=compress&cs=tinysrgb&h=650&w=940'+')',
                            borderRadius: styles.media.borderRadius 
                        == 'round' ? '10px' : '0',
                        }"></div>

                        <input class="input-field" type="text"  
                        :style="{
                            width: '100%',
                            height: '2.5rem',
                            textAlign: 'left',
                            marginBottom: '1rem',
                            paddingLeft: '1rem',
                            backgroundColor: styles.input.backgroundColor,
                            color: styles.input.color,
                            borderRadius: styles.input.borderRadius == 'round' ? '5px' : '0',
                            border: styles.input.border ? `${styles.input.borderWidth} 
                            ${styles.input.borderStyle} ${styles.input.borderColor}` : 'none',
                        }"
                        placeholder="Input field sample"/>

                        <button
                        :style="{
                            backgroundColor: styles.question.backgroundColor,
                            color: styles.question.color,
                            borderRadius: styles.question.borderRadius 
                            == 'round' ? '5px!important' : '0!important',
                            border: styles.question.border ? `${styles.question.borderWidth} ${styles.question.borderStyle} ${styles.question.borderColor}` : 'none',
                        }">Your question goes here ...</button>

                        <button
                        :style="{
                            backgroundColor: styles.button.backgroundColor,
                            color: styles.button.color,
                            borderRadius: styles.button.borderRadius 
                            == 'round' ? '5px' : '0',
                            border: styles.button.border ? `${styles.button.borderWidth} 
                            ${styles.button.borderStyle} ${styles.button.borderColor}` : 'none',
                        }">Button</button>

                        <button class="skippable"
                        :style="{
                            backgroundColor: styles.skip.backgroundColor,
                            color: styles.skip.color,
                            borderRadius: styles.skip.borderRadius == 'round' ? '5px' : '0',
                            border: styles.skip.border ? `${styles.skip.borderWidth} 
                            ${styles.skip.borderStyle} ${styles.skip.borderColor}` : 'none',
                        }"
                        >Skip >></button>

                        <div :style="{
                            width: '100%',
                            textAlign: 'center',
                            paddingTop: '1rem',
                            fontFamily:'Poppins',
                            color: styles.timer.color,
                            textAlign: styles.timer.position,
                        }">00:00:00</div>

                    </div>
                </div>      
            </div>


            <div style="margin-top:3rem;font-size:1.6rem;font-weight:bold;">Themes</div>
            <div class="table-area mt-5">
            <table class="table table-hover lead-table mt-5">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(theme, index) in themes.data" :key="index"
                    @click.stop="selectTheme(index)">
                        <td scope="row">@{{index+1}}</td>
                        <td>@{{theme.name}}</td>
                        <td>
                            <button class="dropdown-item" type="button" 
                                @click="deleteTheme(theme.uuid)">
                                    <i class="far fa-trash-alt"></i> &nbsp; Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>            
            </div>

        <div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item" v-if="themes.current_page > 1" 
                        @click="paginate('previous')">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item page-item-disabled disabled" v-else>
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item" v-if="themes.current_page < themes.last_page"
                     @click="paginate('next')">
                        <a class="page-link">Next</a>
                    </li>
                    <li class="page-item page-item-disabled disabled" v-else>
                        <a class="page-link" disabled>Next</a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" 
            style="background:transparent!important;width:30%;margin-left:35%;"> 
            <div class="modal-content" style="background:transparent!important;">
                <div class="right-content" v-if="step == 1" style="width:100%;">
                    <div class="content"
                    :style="{
                        backgroundColor: styles.background.backgroundColor,
                        borderRadius: styles.background.borderRadius 
                        == 'round' ? '10px' : '0',
                        border: styles.background.border ? `${styles.background.borderWidth} 
                        ${styles.background.borderStyle} ${styles.background.borderColor}` : 'none',
                    }">
                        <p :style="{
                            color: styles.description.color,
                        }">You are welcome</p>

                        <div class="showpreimg"
                        :style="{
                            backgroundImage: 'url('+'https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg?auto=compress&cs=tinysrgb&h=650&w=940'+')',
                            borderRadius: styles.media.borderRadius 
                        == 'round' ? '10px' : '0',
                        }"></div>

                        <button :style="{
                            backgroundColor: styles.button.backgroundColor,
                            color: styles.button.color,
                            borderRadius: styles.button.borderRadius 
                            == 'round' ? '5px' : '0',
                            border: styles.button.border ? `${styles.button.borderWidth} 
                            ${styles.button.borderStyle} ${styles.button.borderColor}` : 'none',
                        }"
                        @click="() => step = 2">Click here</button>

                    </div>
                </div>                

                <div class="right-content" v-if="step == 2" style="width:100%;">
                    <div class="content"
                    :style="{
                        backgroundColor: styles.background.backgroundColor,
                        borderRadius: styles.background.borderRadius 
                        == 'round' ? '10px' : '0',
                        border: styles.background.border ? `${styles.background.borderWidth} ${styles.background.borderStyle} ${styles.background.borderColor}` : 'none',
                    }">
                        <p :style="{
                            color: styles.description.color,
                        }">What is your gender?</p>

                        <div class="showpreimg"
                        :style="{
                            backgroundImage: 'url('+'https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg?auto=compress&cs=tinysrgb&h=650&w=940'+')',
                            borderRadius: styles.media.borderRadius == 'round' ? '10px' : '0',
                        }"></div>

                        <button 
                        :style="{
                            backgroundColor: styles.question.backgroundColor,
                            color: styles.question.color,
                            borderRadius: styles.question.borderRadius 
                            == 'round' ? '5px!important' : '0!important',
                            border: styles.question.border ? `${styles.question.borderWidth} ${styles.question.borderStyle} ${styles.question.borderColor}` : 'none',
                        }" @click="() => step = 3">Male</button>

                        <button :style="{
                            backgroundColor: styles.question.backgroundColor,
                            color: styles.question.color,
                            borderRadius: styles.question.borderRadius 
                            == 'round' ? '5px!important' : '0!important',
                            border: styles.question.border ? `${styles.question.borderWidth} ${styles.question.borderStyle} ${styles.question.borderColor}` : 'none',
                        }" @click="() => step = 3">Female</button>

                        <button class="skippable"
                        :style="{
                            backgroundColor: styles.skip.backgroundColor,
                            color: styles.skip.color,
                            borderRadius: styles.skip.borderRadius == 'round' ? '5px' : '0',
                            border: styles.skip.border ? `${styles.skip.borderWidth} 
                            ${styles.skip.borderStyle} ${styles.skip.borderColor}` : 'none',
                        }" @click="() => step = 3">Skip >></button>

                        <div :style="{
                            width: '100%',
                            textAlign: 'center',
                            paddingTop: '1rem',
                            fontFamily:'Poppins',
                            color: styles.timer.color,
                            textAlign: styles.timer.position,
                        }">00:00:00</div>
                    </div>
                </div>

                <div class="right-content" v-if="step == 3" style="width:100%;">
                    <div class="content"
                    :style="{
                        backgroundColor: styles.background.backgroundColor,
                        borderRadius: styles.background.borderRadius 
                        == 'round' ? '10px' : '0',
                        border: styles.background.border ? `${styles.background.borderWidth} ${styles.background.borderStyle} ${styles.background.borderColor}` : 'none',
                    }">
                        <p :style="{
                            color: styles.description.color,
                        }">Hello CTA</p>

                        <div class="showpreimg"
                        :style="{
                            backgroundImage: 'url('+'https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg?auto=compress&cs=tinysrgb&h=650&w=940'+')',
                            borderRadius: styles.media.borderRadius 
                        == 'round' ? '10px' : '0',
                        }"></div>
                        
                        <button
                        :style="{
                            backgroundColor: styles.button.backgroundColor,
                            color: styles.button.color,
                            borderRadius: styles.button.borderRadius 
                            == 'round' ? '5px' : '0',
                            border: styles.button.border ? `${styles.button.borderWidth} ${styles.button.borderStyle} ${styles.button.borderColor}` : 'none',
                        }" @click="() => step = 4">Thank you</button>
                    </div>
                </div>

                <div class="right-content" v-if="step == 5" style="width:100%;">
                    <div class="content"
                    :style="{
                        backgroundColor: styles.background.backgroundColor,
                        borderRadius: styles.background.borderRadius 
                        == 'round' ? '10px' : '0',
                        border: styles.background.border ? `${styles.background.borderWidth} ${styles.background.borderStyle} ${styles.background.borderColor}` : 'none',
                    }">
                        <p :style="{
                            color: styles.description.color,
                        }">Hello Result</p>

                        <div class="showpreimg"
                        :style="{
                            backgroundImage: 'url('+'https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg?auto=compress&cs=tinysrgb&h=650&w=940'+')',
                            borderRadius: styles.media.borderRadius == 'round' ? '10px' : '0',
                        }"></div>
                        
                        <button
                        :style="{
                            backgroundColor: styles.button.backgroundColor,
                            color: styles.button.color,
                            borderRadius: styles.button.borderRadius 
                            == 'round' ? '5px' : '0',
                            border: styles.button.border ? `${styles.button.borderWidth} ${styles.button.borderStyle} 
                            ${styles.button.borderColor}` : 'none',
                        }" @click="() => step = 1">Submit</button>
                    </div> 
                </div>

                <div class="right-content" v-if="step == 4" style="width:100%;">
                    <div class="content"
                    :style="{
                        backgroundColor: styles.background.backgroundColor,
                        borderRadius: styles.background.borderRadius 
                        == 'round' ? '10px' : '0',
                        border: styles.background.border ? `${styles.background.borderWidth} 
                        ${styles.background.borderStyle} ${styles.background.borderColor}` : 'none',
                    }">
                        <p :style="{
                            color: styles.description.color,
                        }">Hello Leads</p>

                        <div class="showpreimg"
                        :style="{
                            backgroundImage: 'url('+'https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg?auto=compress&cs=tinysrgb&h=650&w=940'+')',
                            height: '15rem', 
                            borderRadius: styles.media.borderRadius == 'round' ? '10px' : '0',
                        }"></div>

                        <input type="text" class="input-field"
                        :style="{
                            width: '100%',
                            height: '2.5rem',
                            textAlign: 'left',
                            marginBottom: '1rem',
                            paddingLeft: '1rem',
                            backgroundColor: styles.input.backgroundColor,
                            color: styles.input.color,
                            borderRadius: styles.input.borderRadius == 'round' ? '5px' : '0',
                            border: styles.input.border ? `${styles.input.borderWidth} 
                            ${styles.input.borderStyle} ${styles.input.borderColor}` : 'none',
                        }"
                        placeholder="Enter your name"/>

                        <input type="email" class="input-field" 
                        :style="{
                            width: '100%',
                            height: '2.5rem',
                            textAlign: 'left',
                            marginBottom: '1rem',
                            paddingLeft: '1rem',
                            backgroundColor: styles.input.backgroundColor,
                            color: styles.input.color,
                            borderRadius: styles.input.borderRadius == 'round' ? '5px' : '0',
                            border: styles.input.border ? `${styles.input.borderWidth} 
                            ${styles.input.borderStyle} ${styles.input.borderColor}` : 'none',
                        }"
                        placeholder="Enter your email"/>

                        <input type="text" class="input-field"
                        :style="{
                            width: '100%',
                            height: '2.5rem',
                            textAlign: 'left',
                            marginBottom: '1rem',
                            paddingLeft: '1rem',
                            backgroundColor: styles.input.backgroundColor,
                            color: styles.input.color,
                            borderRadius: styles.input.borderRadius == 'round' ? '5px' : '0',
                            border: styles.input.border ? `${styles.input.borderWidth} 
                            ${styles.input.borderStyle} ${styles.input.borderColor}` : 'none',
                        }"
                        placeholder="Enter your mobile"/>
                        
                        <button style="margin-top:0"
                        :style="{
                            backgroundColor: styles.button.backgroundColor,
                            color: styles.button.color,
                            borderRadius: styles.button.borderRadius 
                            == 'round' ? '5px' : '0',
                            border: styles.button.border ? `${styles.button.borderWidth} 
                            ${styles.button.borderStyle} ${styles.button.borderColor}` : 'none',
                        }" @click="() => step = 5">Submit</button>

                    </div>                  
                </div>
            </div>
            </div>
        </div>

        </div>

    </section>

@endsection
@section('scripts')
<script>

    const styles = {
        background: {
            backgroundColor: '',
            borderRadius: 'round',
            border: false,
            borderWidth: '1px',
            borderStyle: 'solid',
            borderColor: '',
        },
        description: {
            color: '',
        },
        media: {
            borderRadius: 'round',
        },
        input: {
            backgroundColor: '',
            color: '',
            borderRadius: 'round',
            border: false,
            borderWidth: '1px',
            borderStyle: 'solid',
            borderColor: '',
            placeholderColor: '',
        },
        question: {
            backgroundColor: '',
            color: '',
            borderRadius: 'round',
            border: false,
            borderWidth: '1px',
            borderStyle: 'solid',
            borderColor: '',
        },
        button: {
            backgroundColor: '',
            color: '',
            border: false,
            borderRadius: 'round',
            borderWidth: '1px',
            borderStyle: 'solid',
            borderColor: '',
        },
        skip: {
            backgroundColor: '',
            color: '',
            borderRadius: 'round',
            border: false,
            borderWidth: '1px',
            borderStyle: 'solid',
            borderColor: '',
        },
        timer: {
            color: '',
            position: 'center'
        }
                
    };

    new Vue({
        el: "#app",
        data: {
            step: 1,
            name: '',
            loading: false,
            openSettings: {
                background: true,
                description: false,
                media: false,
                input: false,
                question: false,
                button: false,
                skip: false,
                timer: false,
            },
            styles: styles,
            themes: {},
            page: 1,
            edit: false,
            uuid: '',
            error: false,
        },
        methods: {
            selectTheme(index){
                this.edit = true;
                const theme = this.themes.data.find((each, i) => i == index);

                this.styles = JSON.parse(JSON.parse(theme.json));
                this.name = theme.name;
                this.uuid = theme.uuid;

                console.log('theme.....', JSON.parse(JSON.parse(theme.json)), styles);
            },
            paginate(type){
                if(type == 'previous'){
                    this.page -= 1;
                } else {
                    this.page += 1;
                }

                this.fetchThemes();
            },
            setRadio(styleType, char, value){
                this.styles[styleType][char] = value;
            },
            setColor(styleType, char, ref){
                this.styles[styleType][char] = this.$refs[ref].value;
            },
            deleteTheme(uuid){
                this.loading = true;

                axios
                .delete(`/api/templates/${uuid}`, { 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                }
            })
                .then((response) => {
                    this.fetchThemes();
                    this.loading = false;
                    this.styles = styles;
                    this.name = '';
                    this.uuid = '';
                    this.edit = false;                
                })
                .catch((err) => {
                    this.loading = false;
                    console.log("err", err);
                });
            },
            saveTheme(){
                this.loading = true;

                if(!this.name.trim()){
                    this.error = true;
                    return 
                }

                this.error = false;

                axios
                .post(`/api/templates`, {
                    name: this.name,
                    json: JSON.stringify(this.styles)
                }, { 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                }
            })
                .then((response) => {
                    this.fetchThemes();
                    this.loading = false;
                    this.styles = styles;
                    this.name = '';
                    this.uuid = ''; 
                    this.edit = false; 
                })
                .catch((err) => {
                    console.log("err", err);
                    this.loading = false;
                });
            },
            updateTheme(){
                this.loading = true;

                if(!this.name.trim()){
                    this.error = true;
                    return 
                }

                this.error = false;

                axios
                .put(`/api/templates/${this.uuid}`, {
                    name: this.name,
                    json: JSON.stringify(this.styles)
                }, { 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                }
                })
                .then((response) => {
                    this.fetchThemes();
                    this.loading = false;
                    this.styles = styles;
                    this.name = '';
                    this.uuid = ''    
                    this.edit = false;
                })
                .catch((err) => {
                    console.log("err", err);
                    this.loading = false;
                });
            },
            fetchThemes(){
                axios.get(`/api/templates?page=${this.page}`)
                .then((response) => {
                    this.loading = false;
                    this.themes = response.data.templates;
                })
                .catch((err) => {
                    console.log("err", err);
                    this.loading = false;
                });
            }
        },
        mounted() {
            this.fetchThemes();
        },
    })
</script>

@endsection
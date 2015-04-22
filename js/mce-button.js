/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function() {
    tinymce.PluginManager.add('pams_mce_button_1', function(editor, url) {
        editor.addButton('pams_mce_button_1', {
            text: 'Procedure',
            icon: false,
            onclick: function() {
                editor.insertContent(
                        "<h2>Procedure</h2>" +
                        "[Describe the purpose]" +
                        "<h2>Scope</h2>" +
                        "[Describe the scope]" +
                        "<h2>Responsibilities</h2>" +
                        "[Describe who is responsible for the major activities]" +
                        "<h2>Term and definitions</h2>" +
                        "<table>" +
                        "<thead>" +
                        "<tr>" +
                        "<th><strong>Term</strong></th>" +
                        "<th><strong>Definition</strong></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "<tr>" +
                        "<td>Term 1</td>" +
                        "<td>Definition 1</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Term 2</td>" +
                        "<td>Definition 2</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Term 3</td>" +
                        "<td>Definition 3</td>" +
                        "</tr></tbody>" +
                        "</table>" +
                        "<h2>Activities</h2>" +
                        "[pams_show_activities/]");
                8
            }
        });
    });
})();

(function() {
    tinymce.PluginManager.add('pams_mce_button_2', function(editor, url) {
        editor.addButton('pams_mce_button_2', {
            text: 'Instruction',
            icon: false,
            onclick: function() {
                editor.insertContent(
                        "<h2>Instruction</h2>" +
                        "[Describe the purpose]" +
                        "<h2>Scope</h2>" +
                        "[Describe the scope]" +
                        "<h2>Responsibilities</h2>" +
                        "[Describe who is responsible for the major activities]" +
                        "<h2>Term and definitions</h2>" +
                        "<table>" +
                        "<thead>" +
                        "<tr>" +
                        "<th><strong>Term</strong></th>" +
                        "<th><strong>Definition</strong></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                        "<tr>" +
                        "<td>Term 1</td>" +
                        "<td>Definition 1</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Term 2</td>" +
                        "<td>Definition 2</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Term 3</td>" +
                        "<td>Definition 3</td>" +
                        "</tr></tbody>" +
                        "</table>");
                9
            }
        });
    });
})();

(function() {
    tinymce.PluginManager.add('pams_mce_button_3', function(editor, url) {
        editor.addButton('pams_mce_button_3', {
            text: 'Insert activities',
            icon: false,
            onclick: function() {
                editor.insertContent( "[pams_show_activities/]" );
                10
            }
        });
    });
})();


(function() {
    tinymce.PluginManager.add('pams_mce_button_4', function(editor, url) {
        editor.addButton('pams_mce_button_4', {
            text: 'Insert Definitionbox',
            icon: false,
            onclick: function() {
                editor.insertContent( "[bn_definitionbox ids='104,531'][/bn_definitionbox]" );
                10
            }
        });
    });
})();
<?php
    header("Content-type: text/css");
?>

table, th, td {
    background-color: #f5f5f5;
    border: 1px solid black;
}

th {
    text-decoration: underline;
}

body {
    background-image: url("index_bg.jpg");
}

input.align {
  display: inline-block;
  float: right;
}

div.form {
    margin: auto;
    width: 25%;
    padding: 80px;
}

div.journey_list {
    width: 8%;
    margin: auto;
    padding: 50px;
}

div.etape_added {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #f5f5f5;
}

div.etape_list {
    width: 50%;
    margin: auto;
}

input.delete {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: center;
    cursor: pointer;
    float: right;
}

input.required {
    border: red;
}

caption.table_title {
    font-weight: bold;
    font-size; 20px;
}

form.add_etape {
    margin: auto;
    width: 100%;
}

p.link {
    font-weight: bold;
}

label.label_background {
    background-color: #f5f5f5;
}

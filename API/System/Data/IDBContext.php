<?php
namespace System\Data;

interface IDBContext{
    public function Connect();
    public function Disconnect();
    public function GetError();
    public function GetNumRows();
    public function FreeResult();
}
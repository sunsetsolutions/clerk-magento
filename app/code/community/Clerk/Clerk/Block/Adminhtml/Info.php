<?php

class Clerk_Clerk_Block_Adminhtml_Info extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<h3>Aviso</h3>';
        $html .= '<p>O módulo do Clerk só pode ser configurado em uma loja ativa.</p>';
        $html .= '<p>Por favor, selecione uma loja para poder continuar.</p>';

        return $html;
    }
}

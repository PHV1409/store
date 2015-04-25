<?php
namespace Store\BackendBundle\Doctrine\Extensions;


use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Class qui ajoute la fonction MONTH() en DQL
 * Class Month
 * @package Store\BackendBundle\Doctrine\Extensions
 */
class DateFormat extends FunctionNode{
    /**
     * @var attribut dateExpression
     */
    protected $dateExpression;
    /**
     * @var attribut formatChar
     */
    protected $formatChar;

    /**
     * Parse le DQL en SQL en utilisant SqlWalker
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        // Je retourne la fonction en SQL DATE_FORMAT()
        // qui va prendre en argument
        // ce que j'ai saisi en argument
        return 'DATE_FORMAT('.
            $sqlWalker->walkArithmeticExpression($this->dateExpression) .
            ','. $sqlWalker->walkStringPrimary($this->formatChar) .
        ')';
    }

    /**
     * Parse va utiliser le Parser de Doctrine pour parser ma fonction
     * DATE_FORMAT() en DQL
     * @param \Doctrine\ORM\Query\Parser $parser
     *
     * @return void
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        // Identifie la fonction que l'on va identifier: DATE_FORMAT
        $parser->match(Lexer::T_IDENTIFIER);

        //Identifie la parenthèse ouvrante : (
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        // Identifie l'expression que l'on va donner
        // dans la fonction DATE_FORMAT()
        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->formatChar = $parser->StringPrimary();
        // Identifie la parenthèse fermante
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

    }

} 
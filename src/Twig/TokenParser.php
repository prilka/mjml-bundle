<?php

namespace NotFloran\MjmlBundle\Twig;

use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Twig_TokenParser;
use Twig_Token;

class TokenParser extends Twig_TokenParser
{
    /**
     * @var RendererInterface
     */
    protected $mjml;

    public function __construct(RendererInterface $mjml)
    {
        $this->mjml = $mjml;
    }

    /**
     * Parse the twig tag.
     *
     * @param Twig_Token $token
     * @return Node|\Twig_Node
     * @throws \Twig_Error_Syntax
     */
    public function parse(Twig_Token $token)
    {
        $line = $token->getLine();

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse(function (Twig_Token $token) {
            return $token->test('endmjml');
        }, true);

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new Node($body, $line, $this->getTag());
    }

    /**
     * Return the name of the twig tag.
     *
     * @return string
     */
    public function getTag()
    {
        return 'mjml';
    }

    /**
     * Return the mjml instance being used.
     *
     * @return RendererInterface
     */
    public function getMjml() : RendererInterface
    {
        return $this->mjml;
    }
}

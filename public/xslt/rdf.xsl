<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
    xmlns:owl="http://www.w3.org/2002/07/owl#"
    xmlns:dbpprop="http://dbpedia.org/property/"
    xmlns:dcterms="http://purl.org/dc/terms/"
    xmlns:grs="http://www.georss.org/georss/"
    xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
    xmlns:dbpedia-owl="http://dbpedia.org/ontology/"
    xmlns:foaf="http://xmlns.com/foaf/0.1/"
    xmlns:prov="http://www.w3.org/ns/prov#"
    xmlns:ns10="http://dbpedia.org/ontology/PopulatedPlace/"
    exclude-result-prefixes="xs"
    version="1.0">

<xsl:output indent="yes" />

    <xsl:template match="/">

        <!-- Create response XML -->
        <xsl:element name="result">

            <!-- description -->
            <xsl:element name="description">
                <xsl:value-of select="/rdf:RDF/rdf:Description/dbpedia-owl:abstract[@xml:lang='en']" />
            </xsl:element>

            <!-- latitude -->
            <xsl:element name="latitude">
                <xsl:value-of select="/rdf:RDF/rdf:Description/geo:lat" />
            </xsl:element>

            <!-- longitude -->
            <xsl:element name="longitude">
                <xsl:value-of select="/rdf:RDF/rdf:Description/geo:long" />
            </xsl:element>

        </xsl:element>
        <!-- End of create response XML -->

   </xsl:template>

</xsl:stylesheet>
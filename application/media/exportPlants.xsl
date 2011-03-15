<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:exslt="http://exslt.org/common">


<xsl:template match="/">
  <xsl:for-each select="plants/plant">
    @<xsl:value-of select="id"/>
    @<xsl:value-of select="title"/>
    @<xsl:value-of select="scientificName"/>
    @<xsl:value-of select="season"/>
    @<xsl:value-of select="habitat"/>
    @<xsl:value-of select="plantRange"/>
    @<xsl:value-of select="placeOfOrigin"/>
    @<xsl:value-of select="howToSpot"/>
    @<xsl:value-of select="generalInfo"/>
    @<xsl:value-of select="positiveId"/>
    @<xsl:value-of select="harvesting"/>
    @<xsl:value-of select="cooking"/>
    @<xsl:value-of select="nutrition"/>
    @<xsl:value-of select="medicinalUses"/>
    @<xsl:value-of select="cautions"/>
    @<xsl:value-of select="similarPlants"/>
    @<xsl:value-of select="poisonousLookalike"/>
    @<xsl:value-of select="commonNames"/>
    @<xsl:value-of select="native"/>
    @<xsl:value-of select="hasPoisonousLookalikes"/>
    @<xsl:value-of select="common"/>
    @<xsl:value-of select="endangered"/>
    @<xsl:value-of select="plantType/annual"/>
    @<xsl:value-of select="plantType/biennial"/>
    @<xsl:value-of select="plantType/perennialHerbaceous"/>
    @<xsl:value-of select="plantType/vine"/>
    @<xsl:value-of select="plantType/shrub"/>
    @<xsl:value-of select="plantType/tree"/>
    @<xsl:value-of select="plantType/seaweed"/>
    @<xsl:value-of select="poisonous"/>
    @<xsl:value-of select="poisonousPart"/>
    @<xsl:value-of select="seasonsEdible/earlySpring"/>
    @<xsl:value-of select="seasonsEdible/midSpring"/>
    @<xsl:value-of select="seasonsEdible/lateSpring"/>
    @<xsl:value-of select="seasonsEdible/earlySummer"/>
    @<xsl:value-of select="seasonsEdible/midSummer"/>
    @<xsl:value-of select="seasonsEdible/lateSummer"/>
    @<xsl:value-of select="seasonsEdible/earlyFall"/>
    @<xsl:value-of select="seasonsEdible/midFall"/>
    @<xsl:value-of select="seasonsEdible/lateFall"/>
    @<xsl:value-of select="seasonsEdible/winter"/>
    @<xsl:value-of select="primarySeasonsEdible/earlySpring"/>
    @<xsl:value-of select="primarySeasonsEdible/midSpring"/>
    @<xsl:value-of select="primarySeasonsEdible/lateSpring"/>
    @<xsl:value-of select="primarySeasonsEdible/earlySummer"/>
    @<xsl:value-of select="primarySeasonsEdible/midSummer"/>
    @<xsl:value-of select="primarySeasonsEdible/lateSummer"/>
    @<xsl:value-of select="primarySeasonsEdible/earlyFall"/>
    @<xsl:value-of select="primarySeasonsEdible/midFall"/>
    @<xsl:value-of select="primarySeasonsEdible/lateFall"/>
    @<xsl:value-of select="primarySeasonsEdible/winter"/>
    @<xsl:value-of select="habitats/lawns"/>,
    @<xsl:value-of select="habitats/fields"/>,
    @<xsl:value-of select="habitats/thickets"/>,
    @<xsl:value-of select="habitats/woodlands"/>,
    @<xsl:value-of select="habitats/wetlands"/>,
    @<xsl:value-of select="habitats/marshes"/>,
    @<xsl:value-of select="habitats/swamps"/>,
    @<xsl:value-of select="habitats/seashore"/>,
    @<xsl:value-of select="habitats/disturbed"/>,
    @<xsl:value-of select="habitats/edgeHabitats"/>,
    @<xsl:value-of select="habitats/trailAndRoadside"/>,
    @<xsl:value-of select="habitats/bogs"/>,
    @<xsl:value-of select="habitats/riversLakes"/>,
    @<xsl:value-of select="habitats/parks"/>,
    @<xsl:value-of select="habitats/cultivatedPlaces"/>,
    @<xsl:value-of select="primaryHabitats/lawns"/>,
    @<xsl:value-of select="primaryHabitats/fields"/>,
    @<xsl:value-of select="primaryHabitats/thickets"/>,
    @<xsl:value-of select="primaryHabitats/woodlands"/>,
    @<xsl:value-of select="primaryHabitats/wetlands"/>,
    @<xsl:value-of select="primaryHabitats/marshes"/>,
    @<xsl:value-of select="primaryHabitats/swamps"/>,
    @<xsl:value-of select="primaryHabitats/seashore"/>,
    @<xsl:value-of select="primaryHabitats/disturbed"/>,
    @<xsl:value-of select="primaryHabitats/edgeHabitats"/>,
    @<xsl:value-of select="primaryHabitats/trailAndRoadside"/>,
    @<xsl:value-of select="primaryHabitats/bogs"/>,
    @<xsl:value-of select="primaryHabitats/riversLakes"/>,
    @<xsl:value-of select="primaryHabitats/parks"/>,
    @<xsl:value-of select="primaryHabitats/cultivatedPlaces"/>,
    @<xsl:value-of select="foodUses/salad"/>, 
    @<xsl:value-of select="foodUses/potherb"/>, 
    @<xsl:value-of select="foodUses/root"/>, 
    @<xsl:value-of select="foodUses/nut"/>, 
    @<xsl:value-of select="foodUses/seed"/>, 
    @<xsl:value-of select="foodUses/seasoning"/>, 
    @<xsl:value-of select="foodUses/tea"/>, 
    @<xsl:value-of select="foodUses/buds"/>, 
    @<xsl:value-of select="foodUses/fruitBerry"/>, 
    @<xsl:value-of select="foodUses/coffee"/>, 
    @<xsl:value-of select="foodUses/flour"/>,
    @<xsl:value-of select="edibleParts/leaves"/>,
    @<xsl:value-of select="edibleParts/flower"/>,
    @<xsl:value-of select="edibleParts/root"/>,
    @<xsl:value-of select="edibleParts/nut"/>,
    @<xsl:value-of select="edibleParts/seed"/>,
    @<xsl:value-of select="edibleParts/stem"/>,
    @<xsl:value-of select="edibleParts/fruitBerry"/>,
    @<xsl:value-of select="edibleParts/pod"/>,
    @<xsl:value-of select="edibleParts/bud"/>,
    @<xsl:value-of select="edibleParts/shoot"/>,
primaryIdentImage
 primaryImage INTEGER,
    @<xsl:value-of select="teaser"/>,
    <xsl:call-template name="listOfSelectedValues">
      <xsl:with-param name="listNodes">
          <xsl:call-template name="translateFoodUses">
            <xsl:with-param name="listNodes" select="foodUses/*"/>
          </xsl:call-template>
      </xsl:with-param>
    </xsl:call-template>
    <xsl:call-template name="listOfSelectedValues">
      <xsl:with-param name="listNodes">
          <xsl:call-template name="translateEdibleParts">
            <xsl:with-param name="listNodes" select="edibleParts/*"/>
          </xsl:call-template>
      </xsl:with-param>
    </xsl:call-template>


    <!--
    <xsl:for-each select="foodUses/salad | foodUses/potherb[contains(.,'1')]">
      <xsl:value-of select="name()"/>
    </xsl:for-each>
    -->
        fullFoodUses text,
        fullEdiblePartsText text,
        fullHabitatsText text,
        fullPrimaryHabitatsText text,
        fullSeasonsText text,
        @<xsl:call-template name="translateSeasons">
          <xsl:with-param name="seasons" select="seasonsEdible/*"/>
        </xsl:call-template>
        fullPrimarySeasonsText text,
        fullEcoStatusText text,
        fullPlantTypeText text,
        class text
      </xsl:for-each>
    </xsl:template>


    <xsl:template name="translateSeasons">
      <xsl:param name="seasons"/>
      <xsl:for-each select="$seasons">
        <xsl:choose>
          <xsl:when test="position() = 0">
            nar
          </xsl:when>
          <xsl:when test=". = ''">
            EMPTY
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="."/>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:for-each>
    </xsl:template>

    <xsl:template name="translateEdibleParts">
      <xsl:param name="listNodes"/>
      <xsl:element name="items">
        <xsl:for-each select="$listNodes">
          <xsl:variable name="translatedValue">
            <xsl:choose>
              <xsl:when test="name() = 'salad'">Salad</xsl:when>
              <xsl:when test="name() = 'potherb'">Potherb</xsl:when>
              <xsl:when test="name() = 'root'">Root</xsl:when>
              <xsl:when test="name() = 'nut'">Nut</xsl:when>
              <xsl:when test="name() = 'seed'">Seed</xsl:when>
              <xsl:when test="name() = 'seasoning'">Seasoning</xsl:when>
              <xsl:when test="name() = 'tea'">Tea</xsl:when>
              <xsl:when test="name() = 'fruitBerry'">Fruit/Berry</xsl:when>
            </xsl:choose>
          </xsl:variable>
          <xsl:if test="string-length($translatedValue)">
            <xsl:element name="item">
              <xsl:element name="name">
                <xsl:value-of select="$translatedValue"/>
              </xsl:element>
              <xsl:element name="value">
                <xsl:value-of select="."/>
              </xsl:element>
            </xsl:element>
          </xsl:if>
        </xsl:for-each>
      </xsl:element>
    </xsl:template>

    <xsl:template name="translateFoodUses">
      <xsl:param name="listNodes"/>
      <xsl:element name="items">
        <xsl:for-each select="$listNodes">
          <xsl:variable name="translatedValue">
            <xsl:choose>
              <xsl:when test="name() = 'salad'">Salad</xsl:when>
              <xsl:when test="name() = 'potherb'">Potherb</xsl:when>
              <xsl:when test="name() = 'root'">Root</xsl:when>
              <xsl:when test="name() = 'nut'">Nut</xsl:when>
              <xsl:when test="name() = 'seed'">Seed</xsl:when>
              <xsl:when test="name() = 'seasoning'">Seasoning</xsl:when>
              <xsl:when test="name() = 'tea'">Tea</xsl:when>
              <xsl:when test="name() = 'fruitBerry'">Fruit/Berry</xsl:when>
            </xsl:choose>
          </xsl:variable>
          <xsl:if test="string-length($translatedValue)">
            <xsl:element name="item">
              <xsl:element name="name">
                <xsl:value-of select="$translatedValue"/>
              </xsl:element>
              <xsl:element name="value">
                <xsl:value-of select="."/>
              </xsl:element>
            </xsl:element>
          </xsl:if>
        </xsl:for-each>
      </xsl:element>
    </xsl:template>

    <xsl:template name="listOfSelectedValues">
      <xsl:param name="listNodes"/>
      <xsl:variable name="list">
        <xsl:for-each select="exslt:node-set($listNodes)/items/item">
          <xsl:choose>
            <xsl:when test="value = 1"><xsl:value-of select="name"/>, </xsl:when>
          </xsl:choose>
        </xsl:for-each>
      </xsl:variable>
      <xsl:value-of select="substring($list,1,string-length($list)-2)"/>
    </xsl:template>

  </xsl:stylesheet>

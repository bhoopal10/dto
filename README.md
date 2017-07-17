# Universal Data Transfer and Transformation Object Library

[![Latest Stable Version](https://poser.pugx.org/framesnpictures/universal-dto/v/stable)](https://packagist.org/packages/framesnpictures/universal-dto)
[![Total Downloads](https://poser.pugx.org/framesnpictures/universal-dto/downloads)](https://packagist.org/packages/framesnpictures/universal-dto)
[![Latest Unstable Version](https://poser.pugx.org/framesnpictures/universal-dto/v/unstable)](https://packagist.org/packages/framesnpictures/universal-dto)
[![License](https://poser.pugx.org/framesnpictures/universal-dto/license)](https://packagist.org/packages/framesnpictures/universal-dto)
![Production Environment](https://travis-ci.org/FramesNPictures/universal-dto.svg?branch=master "Production Environment")

## Data Transfer Object Theory

A Data Transfer Object is an object that is used to encapsulate data, and send it from one subsystem of an application to another.

DTOs are most commonly used by the Services layer in an N-Tier application to transfer data between itself and the UI layer. The main benefit here is that it reduces the amount of data that needs to be sent across the wire in distributed applications. They also make great models in the MVC pattern.

Another use for DTOs can be to encapsulate parameters for method calls. This can be useful if a method takes more than 4 or 5 parameters.

Using DTOs internally vastly simplifies PHP code, allowing for code completion and avoiding mistakes in array string keys.

Using it in Repository Pattern in conjunction with Eloquent, allows for true logic and persistence separation.

## Usual Use Cases

### API Output

### Array to Structured Model Conversion

### Data Mapping

### Input Mapping

### Data Transformation, Cleanup and Chaining

## Classes

### Basic DTO

### Flexible DTO

### Mapper
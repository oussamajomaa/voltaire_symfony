<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_document = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publication_place = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publication_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publisher = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publication_place_stated = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publication_date_stated = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $multivolume = null;

    #[ORM\Column(nullable: true)]
    private ?int $volume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marginalia = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $library = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cote = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $provenance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ferney = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $digital_voltaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $external_resource = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $update_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publisher_stated = null;

    #[ORM\Column(nullable: true)]
    private ?int $pot_pourri = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $author;

    #[ORM\ManyToMany(targetEntity: Editor::class, inversedBy: 'books')]
    private Collection $editor;

    #[ORM\ManyToMany(targetEntity: Copyst::class, inversedBy: 'books')]
    private Collection $copyst;

    #[ORM\ManyToMany(targetEntity: Translator::class, inversedBy: 'books')]
    private Collection $translator;

    #[ORM\ManyToMany(targetEntity: Classification::class, inversedBy: 'books')]
    private Collection $classification;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $vol_number = null;

    public function __construct()
    {
        $this->author = new ArrayCollection();
        $this->editor = new ArrayCollection();
        $this->copyst = new ArrayCollection();
        $this->translator = new ArrayCollection();
        $this->classification = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTypeDocument(): ?string
    {
        return $this->type_document;
    }

    public function setTypeDocument(?string $type_document): self
    {
        $this->type_document = $type_document;

        return $this;
    }

    public function getPublicationPlace(): ?string
    {
        return $this->publication_place;
    }

    public function setPublicationPlace(?string $publication_place): self
    {
        $this->publication_place = $publication_place;

        return $this;
    }

    public function getPublicationDate(): ?string
    {
        return $this->publication_date;
    }

    public function setPublicationDate(?string $publication_date): self
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublicationPlaceStated(): ?string
    {
        return $this->publication_place_stated;
    }

    public function setPublicationPlaceStated(?string $publication_place_stated): self
    {
        $this->publication_place_stated = $publication_place_stated;

        return $this;
    }

    public function getPublicationDateStated(): ?string
    {
        return $this->publication_date_stated;
    }

    public function setPublicationDateStated(?string $publication_date_stated): self
    {
        $this->publication_date_stated = $publication_date_stated;

        return $this;
    }

    public function getMultivolume(): ?string
    {
        return $this->multivolume;
    }

    public function setMultivolume(?string $multivolume): self
    {
        $this->multivolume = $multivolume;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getMarginalia(): ?string
    {
        return $this->marginalia;
    }

    public function setMarginalia(?string $marginalia): self
    {
        $this->marginalia = $marginalia;

        return $this;
    }

    public function getLibrary(): ?string
    {
        return $this->library;
    }

    public function setLibrary(?string $library): self
    {
        $this->library = $library;

        return $this;
    }

    public function getCote(): ?string
    {
        return $this->cote;
    }

    public function setCote(?string $cote): self
    {
        $this->cote = $cote;

        return $this;
    }

    public function getProvenance(): ?string
    {
        return $this->provenance;
    }

    public function setProvenance(?string $provenance): self
    {
        $this->provenance = $provenance;

        return $this;
    }

    public function getFerney(): ?string
    {
        return $this->ferney;
    }

    public function setFerney(?string $ferney): self
    {
        $this->ferney = $ferney;

        return $this;
    }

    public function getDigitalVoltaire(): ?string
    {
        return $this->digital_voltaire;
    }

    public function setDigitalVoltaire(?string $digital_voltaire): self
    {
        $this->digital_voltaire = $digital_voltaire;

        return $this;
    }

    public function getExternalResource(): ?string
    {
        return $this->external_resource;
    }

    public function setExternalResource(?string $external_resource): self
    {
        $this->external_resource = $external_resource;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getUpdateDate(): ?string
    {
        return $this->update_date;
    }

    public function setUpdateDate(?string $update_date): self
    {
        $this->update_date = $update_date;

        return $this;
    }

    

    public function getPublisherStated(): ?string
    {
        return $this->publisher_stated;
    }

    public function setPublisherStated(?string $publisher_stated): self
    {
        $this->publisher_stated = $publisher_stated;

        return $this;
    }

    public function getPotPourri(): ?int
    {
        return $this->pot_pourri;
    }

    public function setPotPourri(?int $pot_pourri): self
    {
        $this->pot_pourri = $pot_pourri;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->author->removeElement($author);

        return $this;
    }

    /**
     * @return Collection<int, Editor>
     */
    public function getEditor(): Collection
    {
        return $this->editor;
    }

    public function addEditor(Editor $editor): self
    {
        if (!$this->editor->contains($editor)) {
            $this->editor->add($editor);
        }

        return $this;
    }

    public function removeEditor(Editor $editor): self
    {
        $this->editor->removeElement($editor);

        return $this;
    }

    /**
     * @return Collection<int, Copyst>
     */
    public function getCopyst(): Collection
    {
        return $this->copyst;
    }

    public function addCopyst(Copyst $copyst): self
    {
        if (!$this->copyst->contains($copyst)) {
            $this->copyst->add($copyst);
        }

        return $this;
    }

    public function removeCopyst(Copyst $copyst): self
    {
        $this->copyst->removeElement($copyst);

        return $this;
    }

    /**
     * @return Collection<int, Translator>
     */
    public function getTranslator(): Collection
    {
        return $this->translator;
    }

    public function addTranslator(Translator $translator): self
    {
        if (!$this->translator->contains($translator)) {
            $this->translator->add($translator);
        }

        return $this;
    }

    public function removeTranslator(Translator $translator): self
    {
        $this->translator->removeElement($translator);

        return $this;
    }

    /**
     * @return Collection<int, Classification>
     */
    public function getClassification(): Collection
    {
        return $this->classification;
    }

    public function addClassification(Classification $classification): self
    {
        if (!$this->classification->contains($classification)) {
            $this->classification->add($classification);
        }

        return $this;
    }

    public function removeClassification(Classification $classification): self
    {
        $this->classification->removeElement($classification);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getVolNumber(): ?int
    {
        return $this->vol_number;
    }

    public function setVolNumber(?int $vol_number): self
    {
        $this->vol_number = $vol_number;

        return $this;
    }

}
